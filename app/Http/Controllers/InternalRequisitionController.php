<?php

namespace App\Http\Controllers;

use App\ApproveInternalRequisition;
use App\CertifiedInternalRequisition;
use App\InternalRequisition;
use App\Notifications\InternalRequisitionPublish;
use App\ProcurementMethod;
use App\RequisitionType;
use App\Status;
use App\Stock;
use App\SystemOperations\RequisitionNumberGenerator;
use App\Unit;
use App\UnitOfMeasurement;
use App\User;
use App\Currency;
use App\Institution;
use App\AttachedFile;
use App\Notifications\InternalRequisitionApprovePublish;
use App\Notifications\CertifiedInternalRequisitionPublish;
use App\Comment;
use App\ApproveBudget;
use App\BudgetCommitment;
use Exception;

ini_set('upload_max_filesize', '400M');
ini_set('post_max_size', '400M');


use Illuminate\Http\Request;

class InternalRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {

        $this->middleware('password.expired');
    }
    public function index()
    {
        // $internal = InternalRequisition::find(3);
        // $internal_audit = $internal->audits;
        // $audits = \OwenIt\Auditing\Models\Audit::all();

        // dd($audits);

        //dd($internal_audit);
        if(in_array(auth()->user()->role_id,[1,6,10,11,12,15])){

            if(auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,6,12,15])){
               
                $internal_requisitions = InternalRequisition::with(['user','department','institution','requisition_type','status'])->latest()->get();
                
            }else{
               
            $internal_requisitions = InternalRequisition::with(['user','department','institution','requisition_type','status'])
           // ->where('institution_id', auth()->user()->institution_id)
            ->where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
             ->Orwhere('user_id',auth()->user()->id)
            // ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id())
            ->latest()
            ->get();
            }

        }else if(in_array(auth()->user()->role_id,[2,6,9])){    
        $internal_requisitions = InternalRequisition::with(['user','department','institution','requisition_type','status'])
            ->where('department_id', auth()->user()->department_id)
            ->where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
            ->Orwhere('user_id',auth()->user()->id)
            // ->OrwhereIn('institution_id',auth()->user()->AccessInstitutions())
            ->latest()
            ->get();
        }else{
        
            $internal_requisitions = InternalRequisition::with(['user','department','institution','requisition_type','status'])
            ->where('department_id', auth()->user()->department_id)
           ->whereIn('user_id',User::unitUsers()->pluck('id')->flatten())
            ->Where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
            // ->Orwhere('user_id',auth()->user()->id)
            // ->OrwhereIn('institution_id',auth()->user()->AccessInstitutions())
            ->latest()
            ->get();



        }
  
        return view('/panel.irf.index', compact('internal_requisitions'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $units = UnitOfMeasurement::all();
        $methods = ProcurementMethod::all();
        $types = RequisitionType::all();
        $currencies = Currency::all();
        $institutions = Institution::all();
       // dd(auth()->user()->accessInstitutions_Id()->toArray());

        return view('/panel.irf.create', compact('institutions','currencies','units', 'types', 'methods'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

   // dd($request->all());
     try{
       
        $request->validate([
            'estimated_cost' => 'required',
            'budget_approve' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'requisition_type' => 'required',
            'priority' => 'required',
            'institution_id'=>'required',

            'item_number'=>'required',
            'quantity' => 'required',
            'description' => 'required',
            'estimated_total' => 'required',
            'unit' => 'required',
            'unit_cost' => 'required',
            'currency_type' => 'required',
            'tax'=>'required',
            'currency_type'=>'required',
  

        ]);
        $requisition_no = new RequisitionNumberGenerator();
        $internal_requisition = new InternalRequisition();

        $internal_requisition->requisition_no = $requisition_no->generateRequisitionNumber($request->requisition_type);
        $internal_requisition->user_id = auth()->user()->id;
       // $internal_requisition->institution_id = auth()->user()->institution_id;
       $internal_requisition->institution_id = $request->institution_id;
        $internal_requisition->department_id = auth()->user()->department_id;
        $internal_requisition->estimated_cost = $request->estimated_cost;
        $internal_requisition->budget_approve = $request->budget_approve;
        $internal_requisition->phone = $request->phone;
        $internal_requisition->email = $request->email;
        $internal_requisition->requisition_type_id = $request->requisition_type;
        $internal_requisition->budget_approve = $request->budget_approve;
        $internal_requisition->comments = $request->comments;
        $internal_requisition->priority = $request->priority;
        $internal_requisition->description = $request->general_description;
        $internal_requisition->currency_id = $request->currency_type;
        $internal_requisition->tax_confirmed = $request->tax;
        

        if ($internal_requisition->save()) {

            $input = $request->all();
            // $product = $request->input('product_name',[]);
           
            if ($input['item_number'][0]) {
                foreach ($input['item_number'] as $key => $stocks) {
                    $stock = Stock::create([
                        'item_number' => $input['item_number'][$key],
                        'quantity' => $input['quantity'][$key],
                        'description' => $input['description'][$key],
                        'estimated_total' => $input['estimated_total'][$key],
                        'unit_of_measurement_id' => $input['unit'][$key],
                        'unit_cost' => $input['unit_cost'][$key],
                        'internal_requisition_id' => $internal_requisition->id,
                        
                    ]);

                }

            }
            //update status
            $status = new Status();
            $status->internal_requisition_id = $internal_requisition->id;
            $status->name = 'Internal Requisition';
            $status->save();


            if ($request->file('file_upload')) {
            $files = $request->file('file_upload');
            foreach ($files as $key => $file) {
            $newfile = new AttachedFile();
            if ($request->file('file_upload')) {
            $paths[] = $file->storeAs(
                'public/documents', $file->getClientOriginalName()

            );

            }
            $newfile->filename = $file->getClientOriginalName();
            $newfile->internal_requisition_id = $internal_requisition->id;
            $newfile->save();

    }

}


        }

        $unit_count = Unit::where('department_id', auth()->user()->department_id)->count();

        if ($unit_count == 1 and auth()->user()->role_id !=2 OR (in_array(auth()->user()->role_id, [13]))) {

            $certify = new CertifiedInternalRequisition();
            $certify->internal_requisition_id = $internal_requisition->id;
            $certify->user_id = auth()->user()->id;
            $certify->is_granted = 1;
            if($certify->save()){
                $status = Status::where('internal_requisition_id', $internal_requisition->id)->first();
                $status->name = 'Internal Requisition Certified ';
                $status->update();

                //primary user institution notification
                $users = User::where('institution_id', auth()->user()->institution_id)
                ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id', [2])
                ->get();
                $users->each->notify(new InternalRequisitionPublish($internal_requisition));
                // //subscribe user institution notification
                // $sub_users = User::users_in_institution($internal_requisition->institution_id)->whereIn('role_id',[10,11]);
                // $sub_users->each->notify(new InternalRequisitionPublish($internal_requisition));
                $add_role_user = User::user_with_roles(auth()->user()->institution_id,auth()->user()->department_id,2);
                $add_role_user->each->notify(new InternalRequisitionPublish($internal_requisition));


            }
        

        }else if(auth()->user()->role_id===4)
        {
            $users = User::where('institution_id', auth()->user()->institution_id)
            ->where('department_id', auth()->user()->department_id)
            ->whereIn('role_id', [13])
            ->get();
            $users->each->notify(new CertifiedInternalRequisitionPublish($internal_requisition));

        }

         //if manager create ipr
       else  if(auth()->user()->role_id === 2){
            // Certify by manager
                $certify = new CertifiedInternalRequisition();
                $certify->internal_requisition_id = $internal_requisition->id;
                $certify->user_id = auth()->user()->id;
                $certify->is_granted = 1;
            //approve by manager
                $approve =  new ApproveInternalRequisition();
                $permission = 1;
                $approve->internal_requisition_id = $internal_requisition->id;
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission;
                if($approve->save()){
                                $status = Status::where('internal_requisition_id', $internal_requisition->id)->first();
                                $status->name = 'Internal Requisition Approved ';
                                $status->update();
                                $users = User::where('institution_id', auth()->user()->institution_id)
                                ->whereIn('role_id', [7])
                                ->get();
                                $users->each->notify(new InternalRequisitionApprovePublish($internal_requisition));



                }
               
            }

        }catch(Illuminate\Database\QueryException  $error){
            return edirect('/internal_requisition')->with('error','error something wnent wrong');
        }catch(PDOException $e){
            return edirect('/internal_requisition')->with('error','error something wnent wrong');

        }
            
            

        

        return redirect('/internal_requisition')->with('status', 'Internal Requisition was created successfully, The requisition number is '.$internal_requisition->requisition_no);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $internal_requisition = InternalRequisition::find($id);
        return view('/panel.irf.show', compact('internal_requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $units = UnitOfMeasurement::all();
        //  dd(('test'));
        $ir = InternalRequisition::with(['stocks', 'comment','approve_budget'])
            ->find($id);
        // dd($ir->comment);
        $types = RequisitionType::all();
        $currencies = Currency::all();

        if ($ir->approve_internal_requisition) {
            if ($ir->approve_internal_requisition->is_granted === 1) {
                return redirect('/internal_requisition')->with('error', 'Requisition ' . $ir->requisition_no . ' is already approved.');
            }

        }
        //else{
        //     if($ir->certified_internal_requisition->is_granted===1)
        //     return redirect('/internal_requisition')->with('error', 'Requisition ' . $ir->requisition_no . ' is already certified.');
        // }

        return view('/panel.irf.edit', compact('currencies','units', 'ir', 'types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        try{
        $request->validate([
            'estimated_cost' => 'required',
            'budget_approve' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'requisition_type' => 'required',
            'priority' => 'required',

            'item_number'=>'required',
            'quantity' => 'required',
            'description' => 'required',
            'estimated_total' => 'required',
            'unit' => 'required',
            'unit_cost' => 'required',

        ]);
        $internal_requisition = InternalRequisition::with(['stocks'])->find($id);
       
        if($internal_requisition->estimated_cost == $request->estimated_cost)
        {
        $internal_requisition->estimated_cost = $request->estimated_cost;
        $internal_requisition->budget_approve = $request->budget_approve;
        $internal_requisition->phone = $request->phone;
        $internal_requisition->email = $request->email;
        $internal_requisition->requisition_type_id = $request->requisition_type;
        $internal_requisition->budget_approve = $request->budget_approve;
        $internal_requisition->priority = $request->priority;
        $internal_requisition->comments = $request->comments;
        $internal_requisition->currency_id = $request->currency_type;
        $internal_requisition->tax_confirmed = $request->tax;
        $internal_requisition->description = $request->general_description;
        $input = $request->all();
        foreach ($internal_requisition->stocks as $products) {
        $products->delete();
        }

        if($request->item_number){
        foreach ($input['item_number'] as $key => $stocks) {
                $stock = Stock::create([
                    'item_number' => $input['item_number'][$key],
                    'quantity' => $input['quantity'][$key],
                    'description' => $input['description'][$key],
                    'estimated_total' => $input['estimated_total'][$key],
                    'unit_of_measurement_id' => $input['unit'][$key],
                    'unit_cost' => $input['unit_cost'][$key],
                    'internal_requisition_id' => $internal_requisition->id,
                ]);

        }
    }else{
        $stock=Stock::create([
            'item_number' => 1,
            'quantity' => 0,
            'description' => 'error',
            'estimated_total' => 0,
            'unit_of_measurement_id' => 1,
            'unit_cost' => 0,
            'internal_requisition_id' => $internal_requisition->id,
        ]);;
    }

               
        

        
        }else{
           
            $internal_requisition->estimated_cost = $request->estimated_cost;
            $internal_requisition->budget_approve = $request->budget_approve;
            $internal_requisition->phone = $request->phone;
            $internal_requisition->email = $request->email;
            $internal_requisition->requisition_type_id = $request->requisition_type;
            $internal_requisition->budget_approve = $request->budget_approve;
            $internal_requisition->priority = $request->priority;
            $internal_requisition->comments = $request->comments;
            $internal_requisition->currency_id = $request->currency_type;
            $internal_requisition->tax_confirmed = $request->tax;
        
           // $internal_requisition->update();
            $input = $request->all();
            foreach ($internal_requisition->stocks as $products) {
            $products->delete();
            }

            if ($input['item_number'][0]) {
            foreach ($input['item_number'] as $key => $stocks) {
                $stock = Stock::create([
                    'item_number' => $input['item_number'][$key],
                    'quantity' => $input['quantity'][$key],
                    'description' => $input['description'][$key],
                    'estimated_total' => $input['estimated_total'][$key],
                    'unit_of_measurement_id' => $input['unit'][$key],
                    'unit_cost' => $input['unit_cost'][$key],
                    'internal_requisition_id' => $internal_requisition->id,
                ]);

        }

        }
           
            $budgetApprove = ApproveBudget::where('internal_requisition_id',$internal_requisition->id);
            $budgetApprove->delete();
            $commit = BudgetCommitment::where('internal_requisition_id',$internal_requisition->id);
            $commit->delete();
            $approve = ApproveInternalRequisition::where('internal_requisition_id',$internal_requisition->id);
            $approve->delete();
            $status = Status::where('internal_requisition_id',$internal_requisition->id)->first();
            $status->name = 'Internal Requisition';
            $status->update();
      


        }
        //$internal_requisition->update();
        //delete certify ipr
        if ($internal_requisition->update()) {

            $input = $request->all();
            //reset refuse requisition
            $certify_ipr = CertifiedInternalRequisition::where('internal_requisition_id',$internal_requisition->id)
            ->where('is_granted',0)
            ->first();
            if($certify_ipr != null){
            $certify_ipr->delete();
            }else{
                $certify_ipr= 0;
            }

        }

        $users = User::where('institution_id', auth()->user()->institution_id)
        ->where('department_id', auth()->user()->department_id)
        ->whereIn('role_id', [13])
        ->get();
        $users->each->notify(new CertifiedInternalRequisitionPublish($internal_requisition));

        if ($request->file('file_upload')) {
            $files = $request->file('file_upload');
            foreach ($files as $key => $file) {
            $newfile = new AttachedFile();
            if ($request->file('file_upload')) {
            $paths[] = $file->storeAs(
                'public/documents', $file->getClientOriginalName()

            );

            }
            $newfile->filename = $file->getClientOriginalName();
            $newfile->internal_requisition_id = $internal_requisition->id;
            $newfile->save();

    }

}

          
           
        }catch(Illuminate\Database\QueryException  $error){
            return edirect('/internal_requisition')->with('error','error something wnent wrong');
        }catch(PDOException $e){
            return edirect('/internal_requisition')->with('error','error something wnent wrong');

        }

        

        return redirect('/internal_requisition')->with('status', 'Internal requisition was updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            $internal_requisition = InternalRequisition::find($id);
            if ($internal_requisition->approve_internal_requisition) {
                if ($internal_requisition->approve_internal_requisition->is_granted === 1) {
                    return 'fail';

                }
            }
            $internal_requisition->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }

    }

    public function deleteAttached($id)
    {

        // dd('destroy');
        try {
            $file = AttachedFile::find($id);
            $file->delete();
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }

    }
}
