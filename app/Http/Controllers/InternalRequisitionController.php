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
use App\AttachedFile;
use App\Notifications\InternalRequisitionApprovePublish;
use App\Notifications\CertifiedInternalRequisitionPublish;
use App\Comment;
use App\ApproveBudget;
use App\BudgetCommitment;




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
        $internal_requisitions = InternalRequisition::with(['approve_internal_requisition','department','institution','requisition_type','status'])
            ->where('department_id', auth()->user()->department_id)
            ->where('institution_id', auth()->user()->institution_id)->get();

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

        return view('/panel.irf.create', compact('units', 'types', 'methods'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'estimated_cost' => 'required',
            'budget_approve' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'requisition_type' => 'required',
            'priority' => 'required',

            'quantity' => 'required',
            'description' => 'required',
            // 'part_number' => 'required',
            'unit' => 'required',
            'unit_cost' => 'required',

        ]);
        $requisition_no = new RequisitionNumberGenerator();
        $internal_requisition = new InternalRequisition();

        $internal_requisition->requisition_no = $requisition_no->generateRequisitionNumber($request->requisition_type);
        $internal_requisition->user_id = auth()->user()->id;
        $internal_requisition->institution_id = auth()->user()->institution_id;
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

        if ($internal_requisition->save()) {

            $input = $request->all();
            // $product = $request->input('product_name',[]);
            //  dd($input['part_number'][0]);
            if ($input['item_number'][0]) {
                foreach ($input['item_number'] as $key => $stocks) {
                    $stock = Stock::create([
                        'item_number' => $input['item_number'][$key],
                        'quantity' => $input['quantity'][$key],
                        'description' => $input['description'][$key],
                        'part_number' => $input['part_number'][$key],
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
                $status->name = 'Certified Internal Requisition';
                $status->update();


                $users = User::where('institution_id', auth()->user()->institution_id)
                ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id', [2])
                ->get();
                $users->each->notify(new InternalRequisitionPublish($internal_requisition));


            }
            //set status


            //email supervisor
            // $user=User::find(auth()->user()->id);
            // $user->notify(new InternalRequisitionPublish($internal_requisition));


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
                $approve =  new ApproveInternalRequisition();
                $permission = 1;
                $approve->internal_requisition_id = $internal_requisition->id;
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission;
                if($approve->save()){
                                $status = Status::where('internal_requisition_id', $internal_requisition->id)->first();
                                $status->name = 'Approved Internal Requisition';
                                $status->update();
                                $users = User::where('institution_id', auth()->user()->institution_id)
                                ->whereIn('role_id', [7])
                                ->get();
                                $users->each->notify(new InternalRequisitionApprovePublish($internal_requisition));



                }
               
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

        if ($ir->approve_internal_requisition) {
            if ($ir->approve_internal_requisition->is_granted === 1) {
                return redirect('/internal_requisition')->with('error', 'Requisition ' . $ir->requisition_no . ' is already approved.');
            }

        }
        //else{
        //     if($ir->certified_internal_requisition->is_granted===1)
        //     return redirect('/internal_requisition')->with('error', 'Requisition ' . $ir->requisition_no . ' is already certified.');
        // }

        return view('/panel.irf.edit', compact('units', 'ir', 'types'));

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
                    'part_number' => $input['part_number'][$key],
                    'unit_of_measurement_id' => $input['unit'][$key],
                    'unit_cost' => $input['unit_cost'][$key],
                    'internal_requisition_id' => $internal_requisition->id,
                ]);

        }

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
                    'part_number' => $input['part_number'][$key],
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
      


        }
        $internal_requisition->update();
        $users = User::where('institution_id', auth()->user()->institution_id)
        ->where('department_id', auth()->user()->department_id)
        ->whereIn('role_id', [2])
        ->get();
        $users->each->notify(new InternalRequisitionPublish($internal_requisition));

            // $approve = ApproveInternalRequisition::where('internal_requisition_id', $id)
            //     ->where('is_granted', 1)
            //     ->first();
            // if ($approve != null) {
            //     $approve->delete();
            // } else {
            //     $approve = null;
            // }
            // $certify = CertifiedInternalRequisition::where('internal_requisition_id', $id)
            //     ->where('is_granted', 1)
            //     ->first();
            // if ($certify != null) {
            //     $certify->delete();
            // } else {
            //     $certify = null;
            // }


           

        

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
