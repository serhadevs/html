<?php

namespace App\Http\Controllers;

use App\Department;
use App\File_Upload;
use App\Institution;
use App\ProcurementMethod;
use App\Requisition;
use App\RequisitionType;
use App\Check;
use App\StockCategory;
use App\Supplier;
use App\SystemOperations\RequisitionNumberGenerator;
use App\UnitOfMeasurement;
use Illuminate\Http\Request;
use App\InternalRequisition;
use App\User;
use App\Status;
use App\Notifications\RequisitionPublish;
use Illuminate\Support\Facades\Storage;
use PDF;
use App\Stock;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(Request $request)
    {

        $this->middleware('password.expired');

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,2,5,9,10,11,12])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //  $requisitions = Requisition::with(['check','approve','purchase_order']);

        //dd(auth()->user()->accessInstitutions_Id());
        if (in_array(auth()->user()->role_id,[1,12,10,11])) {

            if(auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,12])  ){

                $requisitions = Requisition::with(['user','check', 'approve','internalrequisition','department','institution','purchaseOrder','category','approve','supplier'])
                 ->latest()
                 ->get();
            }else{
            $requisitions = Requisition::with(['user','check', 'approve','internalrequisition','department','institution','purchaseOrder','category','approve','supplier'])
               // ->where('contract_sum', '>=', 500000)
               ->where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
                ->latest()
                ->get();
            }

        } else {
            $requisitions = Requisition::with(['user','check', 'approve','internalrequisition','department','institution','purchaseOrder','category','approve','supplier'])
               ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
                ->latest()
                ->get();
        }

        // dd($requisitions);
        $internalrequisitions = InternalRequisition::with(['assignto','requisition','approve_internal_requisition','budget_commitment','assignto','approve_budget'])
        ->whereHas('approve_internal_requisition',function($query){
         $query->where('is_granted','=', 1);
        })
       ->doesnthave('requisition')
       ->wherehas('assignto')
       ->where('institution_id',auth()->user()->institution_id)
       ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id())
        
        ->has('approve_budget')
        ->latest()
        ->get();

        return view('/panel.requisition.index', ['requisitions' => $requisitions, 'internalrequisitions'=>$internalrequisitions]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $internalrequisition = InternalRequisition::with('stocks')->find($id);
        $suppliers = Supplier::all();
        $units = UnitOfMeasurement::all();
        $departments = Department::all();
        $institutions = Institution::all();
        $categories = StockCategory::all();
        $types = RequisitionType::all();
        $methods = ProcurementMethod::all();

        return view('panel.requisition.create', compact('internalrequisition','types', 'methods', 'categories', 'suppliers', 'units', 'departments', 'institutions'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
      //  $total = 0;
      
 
        $request->validate([
            // 'requisition_type' => 'required|numeric',
            'cost_centre' => 'required',
            'supplier_id' => 'required',
            'procurement_method' => 'required',
            'delivery' => 'required',
            'category' => 'required',
            'description' => 'required',
            // 'tcc' => 'required|integer|digits_between:3,10',
            //  'trn' => 'required|integer|digits:9',
            // 'tcc_expired_date' => 'required|date',
            // 'estimated_cost' => 'required|numeric',
            'contract_sum' => 'required|numeric',
            'cost_variance' => 'required',
            'commitment' => 'required',

        ]);
        // $requisition_no = new RequisitionNumberGenerator();
        $requisition = new Requisition();
        // $requisition->requisition_type_id = $request->requisition_type;
        $requisition->requisition_no = $request->requisition_no;
        $requisition->department_id = auth()->user()->department->id;
        $requisition->institution_id = auth()->user()->institution->id;
        $requisition->cost_centre = $request->cost_centre;
        $requisition->supplier_id = $request->supplier_id;
        // $requisition->recommended_cost = $request->recommended_cost;
        $requisition->commitment_no = $request->commitment;
        $requisition->user_id = auth()->user()->id;
        // $requisition->date_ordered = $request->date_ordered;
        $requisition->procurement_method_id = $request->procurement_method;
        $requisition->delivery = $request->delivery;
        $requisition->description = $request->description;
        $requisition->category_id = $request->category;
        $requisition->tcc = $request->tcc;
        $requisition->ppc = $request->ppc;
        // $requisition->trn = $request->trn;
        $requisition->tcc_expired_date = $request->tcc_expired_date;
        $requisition->ppc_expired_date = $request->ppc_expired_date;
        // $requisition->estimated_cost = $request->estimated_cost;
        $requisition->contract_sum = $request->contract_sum;
        $requisition->cost_variance = $request->cost_variance;
        // $requisition->date_require = $request->date_require;
        // $requisition->date_last_ordered = $request->date_last_ordered;
        $requisition->internal_requisition_id = $request->id;
        $requisition->tax_confirmed = $request->tax;

        // add stocks to requisition
        if ($requisition->save()) {

            //add actual value to stock table
            $stocks = Stock::where('internal_requisition_id',$request->id)->get();
            foreach ($stocks as $key => $stock) {
   
                       $stock->actual_cost = $request['actual_cost'][$key];
                       $stock->actual_total = $request['actual_total'][$key];
                       $stock->update();
                 
               }

           //upload file

            if ($request->file('file_upload')) {
                $files = $request->file('file_upload');
                foreach ($files as $key => $file) {
                    $newfile = new File_Upload();
                    if ($request->file('file_upload')) {
                        $paths[] = $file->storeAs(
                            'public/documents', $file->getClientOriginalName()

                        );

                    }
                    $newfile->filename = $file->getClientOriginalName();
                    $newfile->requisition_id = $requisition->id;
                    $newfile->save();

                }

            }
            if($requisition->contract_sum >= 500000){
                $users = User::where('institution_id',1 )
                ->whereIn('role_id',[5,9])
                ->get();
            }else{
            $users = User::where('institution_id',auth()->user()->institution_id )
            ->whereIn('role_id',[5,9])
            ->get();
            }
  
            // $requisition = Requisition::find($requisition->id);
        
            $users->each->notify(new RequisitionPublish($requisition));
            
            //update requisition status
            $status = Status::where('internal_requisition_id',$requisition->internalrequisition->id)->first();
            $status->name = 'Requisition';
            $status->update();


        }

        return redirect('/requisition')->with('status', 'Requisition was created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function show(Requisition $requisition)
    {
        //
        //dd($requisition->internalrequisition->stocks);
       
     
      
        return view('panel.requisition.show', ['requisition' => $requisition]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisition $requisition)
    {
        $suppliers = Supplier::all();
    //    $supply =Supplier::find($requisition->supplier_id);
        $units = UnitOfMeasurement::all();
        $categories = StockCategory::all();
        $types = RequisitionType::all();
        $methods = ProcurementMethod::all();
      // $content = Storage::url('app\public\Maintenance Manager JD.docx');
      if ($requisition->check){
        if ($requisition->check->is_check===1) {
            return redirect('/requisition')->with('error', 'Requisition ' . $requisition->requisition_no . ' is already accepted');
        }
    }

        return view('panel.requisition.edit', ['methods' => $methods, 'types' => $types, 'categories' => $categories, 'units' => $units, 'requisition' => $requisition, 'suppliers' => $suppliers]);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisition $requisition)
    {
        //
      // dd($request->all());
        // $total = 0;
        // $requisition->requisition_type_id = $request->requisition_type;
        $requisition->delivery = $request->delivery;
        $requisition->description = $request->description;
        $requisition->category_id = $request->category;
        $requisition->tcc = $request->tcc;
        $requisition->ppc = $request->ppc;
        $requisition->supplier_id = $request->supplier_id;
        $requisition->tcc_expired_date = $request->tcc_expired_date;
        $requisition->ppc_expired_date = $request->ppc_expired_date;
        // $requisition->estimated_cost = $request->estimated_cost;
        $requisition->contract_sum = $request->contract_sum;
        $requisition->procurement_method_id = $request->procurement_method;
        $requisition->cost_variance = $request->cost_variance;
        $requisition->tax_confirmed = $request->tax;
        // $requisition->date_require = $request->date_require;
        // $requisition->date_last_ordered = $request->date_last_ordered;

        //update stock

        if ($requisition->update()) {

            $stocks = Stock::where('internal_requisition_id',$requisition->internal_requisition_id)->get();
            foreach ($stocks as $key => $stock) {
   
                       $stock->actual_cost = $request['actual_cost'][$key];
                       $stock->actual_total = $request['actual_total'][$key];
                       $stock->update();
                 
               }

            $input = $request->all();
            //reset refuse requisition
            $check_id = Check::where('requisition_id',$requisition->id)
            ->where('is_checked',0)
            ->first();
            if($check_id != null){
            $check_id->delete();
            }else{
                $check_id = 0;
            }
          

            if ($request->file('file_upload')) {
                $files = $request->file('file_upload');

                foreach ($files as $key => $file) {
                    $newfile = new File_Upload();
                    if ($request->file('file_upload')) {
                        $paths[] = $file->storeAs(
                            'public/documents', $file->getClientOriginalName()

                        );

                    }
                    $newfile->filename = $file->getClientOriginalName();
                    $newfile->requisition_id = $requisition->id;
                    $newfile->save();

                }

            }

            return redirect('/requisition')->with('status', 'Requisition was updated successfully');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requisition  $requisition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // dd('destroy');
        try {
            $requisition = Requisition::find($id);
            if ($requisition->check){
                if ($requisition->check->is_checked===1) {
                    return 'fail';
                }
            }
            $requisition->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }

    }


    public function printPDF($id)
    {
        $data = [
            'title' => 'First PDF for Medium',
            'heading' => 'South East Regional Health Authority',
            'heading2' => 'The Towers, 25 Dominica Drive, Kingston 5',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'
        ];

         //
             $requisition = Requisition::find($id);
              $pdf = PDF::loadView('/panel/requisition/pdf_requisition', $data,compact('requisition')); 
              return $pdf->download('requsisition'.$requisition->internalrequisition->requisition_no.'.pdf');
    }
    

    public function deleteFile($id)
    {

        // dd('destroy');
        try {
            $file = File_Upload::find($id);
            $file->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }

    }
}
