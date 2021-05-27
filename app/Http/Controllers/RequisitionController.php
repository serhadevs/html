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
use App\Notifications\RequisitionPublish;
use Illuminate\Support\Facades\Storage;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct(Request $request)
    {

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,2,5,9,12])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //  $requisitions = Requisition::with(['check','approve','purchase_order']);

        if (auth()->user()->institution_id === 1) {
            $requisitions = Requisition::with(['check', 'approve'])
                ->where('contract_sum', '>=', 500000)
                ->Orwhere('institution_id', '=', auth()->user()->institution_id)
                ->get();

        } else {
            $requisitions = Requisition::with(['check', 'approve'])
                ->where('institution_id', '=', auth()->user()->institution_id)
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
        
        ->has('approve_budget')
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
        $requisition = InternalRequisition::find($id);
        //dd($requisition);
        $suppliers = Supplier::all();
        $units = UnitOfMeasurement::all();
        $departments = Department::all();
        $institutions = Institution::all();
        $categories = StockCategory::all();
        $types = RequisitionType::all();
        $methods = ProcurementMethod::all();

        return view('panel.requisition.create', compact('requisition','types', 'methods', 'categories', 'suppliers', 'units', 'departments', 'institutions'));

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
             'trn' => 'required|integer|digits:9',
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
        $requisition->trn = $request->trn;
        $requisition->tcc_expired_date = $request->tcc_expired_date;
        $requisition->ppc_expired_date = $request->ppc_expired_date;
        // $requisition->estimated_cost = $request->estimated_cost;
        $requisition->contract_sum = $request->contract_sum;
        $requisition->cost_variance = $request->cost_variance;
        // $requisition->date_require = $request->date_require;
        // $requisition->date_last_ordered = $request->date_last_ordered;
        $requisition->internal_requisition_id = $request->id;
        // $requisition->recommended_cost = $request->recommended_cost;

        // add stocks to requisition
        if ($requisition->save()) {

           

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
                ->whereIn('role_id',[1,5,9])
                ->get();
            }else{
            $users = User::where('institution_id',auth()->user()->institution_id )
            ->where('department_id', auth()->user()->department_id)
            ->whereIn('role_id',[1,5,9])
            ->get();
            }
  
            $internalRequisition = Requisition::find($requisition->id);
        
            $users->each->notify(new RequisitionPublish($internalRequisition));


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
        $units = UnitOfMeasurement::all();
        $categories = StockCategory::all();
        $types = RequisitionType::all();
        $methods = ProcurementMethod::all();
      // $content = Storage::url('app\public\Maintenance Manager JD.docx');
      if ($requisition->approve){
        if ($requisition->approve->is_granted===1) {
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
        $requisition->trn = $request->trn;
        $requisition->tcc_expired_date = $request->tcc_expired_date;
        $requisition->ppc_expired_date = $request->ppc_expired_date;
        // $requisition->estimated_cost = $request->estimated_cost;
        $requisition->contract_sum = $request->contract_sum;
        $requisition->procurement_method_id = $request->procurement_method;
        $requisition->cost_variance = $request->cost_variance;
        // $requisition->date_require = $request->date_require;
        // $requisition->date_last_ordered = $request->date_last_ordered;

        //update stock

        if ($requisition->update()) {

            $input = $request->all();
            //reset refuse requisition
            $check_id = Check::where('requisition_id',$requisition->id)
            ->where('is_refuse',1)
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
            $requisition->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }

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
