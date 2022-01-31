<?php

namespace App\Http\Controllers;

use App\AssignRequisition;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\RequisitionType;
use App\User;
use App\ApproveInternalRequisition;
use App\Notifications\AssignInternalRequisition;
use App\Notifications\RefuseInternalRequisitionPublish;
use App\Comment;
use App\Status;
use App\ApproveBudget;
use App\BudgetCommitment;

class AssignRequisitionController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,9,12])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        $internal_requisitions = InternalRequisition::with(['assignto','approve_internal_requisition','budget_commitment','approve_budget'])
        ->whereHas('approve_internal_requisition',function($query){
         $query->where('is_granted','=', 1);
        })
        ->whereHas('budget_commitment')
        ->whereHas('approve_budget')
        ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
    
        
 
        ->has('approve_budget')
       // ->doesnthave('assignto')
       ->latest()
        ->get();

        return view('/panel.assign.index',compact('internal_requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
       // dd(auth()->user()->institution_id);
       
        $internalRequisition = InternalRequisition::with(['stocks'])->find($id);

        $users = User::
        where(function($query)use($internalRequisition){
        $query->where('institution_id','=',$internalRequisition->institution_id)
        ->OrWhereIn('id',User:: users_in_institution_ids($internalRequisition->institution_id));
        })
        ->whereIn('role_id',[5,9])
        ->get();
       
         
        if ($internalRequisition->assignto) {
            return reirect('/assign_requisition')->with('error', 'The Internal Requisition is already assign to'.' ' . $internalRequisition->assignto->user->lastname);
        }
        return view('/panel.assign.create',compact('internalRequisition','users'));
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
       $assignee = new AssignRequisition();
       $assignee->user_id = $request->user_id;
       $assignee->internal_requisition_id = $request->requisition_id;
      
       $assignee->save();

        //send email to assigned task
       $internal_requisition = InternalRequisition::find($request->requisition_id);
       $user = User::where('id',$request->user_id)->get();
   
       $user->each->notify(new AssignInternalRequisition($internal_requisition));


       return redirect('/assign_requisition')->with('status', 'The internal requisition was assign to procurement officer successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //  dd('test');
        $internalRequisition = InternalRequisition::find($id);
        return view('//panel.assign.show', compact('internalRequisition'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
     
        $users = User::
        where(function($query)use($internalRequisition){
        $query->where('institution_id','=',$internalRequisition->institution_id)
        ->OrWhereIn('id',User:: users_in_institution_ids($internalRequisition->institution_id));
        })
        ->whereIn('role_id',[5,9])
        ->get();
        return view('/panel.assign.edit',compact('internalRequisition','users'));
    }

    /**
     * Update the specified resource in storage.
     
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignRequisition $assignRequisition)
    {
        //
       // dd($request->all());
        $assign = AssignRequisition::where('internal_requisition_id',$request->requisition_id)->first();
       // dd($assign);
        $assign->user_id = $request->user_id;
        $assign->update();

        //send email to assigned task
       $internal_requisition = InternalRequisition::find($request->requisition_id);
       $user = User::where('id',$request->user_id)->get();
   
       $user->each->notify(new AssignInternalRequisition($internal_requisition));

        return redirect('/assign_requisition')->with('status', 'Updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssignRequisition  $assignRequisition
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignRequisition $assignRequisition)
    {
        //
    }

    //request for more information 
    public function request(Request $request)
    {
        //
        try {
            $requisition_id =$request->data['internal_requisition_id'];
            $permission = $request->data['permission'];
            $approve  = ApproveInternalRequisition::where('internal_requisition_id',$requisition_id)->first();
            $approve->delete();
                $comment = new Comment();
                $comment->internal_requisition_id =  $requisition_id ;
                $comment->type ='request more information';
                $comment->user_id = auth()->user()->id;
                $comment->comment =  $request->data['comment'];
                $comment->save();
                $status = Status::where('internal_requisition_id',$requisition_id)->first();
                $status->name = 'Request more info';
                $status->update();
                //notification send by mail
                $internal_requisition = InternalRequisition::find($requisition_id);
                $user = User::find($internal_requisition->user_id);
                $user->notify(new RefuseInternalRequisitionPublish($internal_requisition,$comment));

            
            return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }

    }
    // reset ipr to start from the begining of the process
    public function undo(Request $request)
    {
        //
        try {
            
            $requisition_id = $request->data['internal_requisition_id'];
            $budgetApprove = ApproveBudget::where('internal_requisition_id',$requisition_id)->first();
            $commit = BudgetCommitment::where('internal_requisition_id',$requisition_id)->first();
            $approve = ApproveInternalRequisition::where('internal_requisition_id',$requisition_id)->first();
            $internal_requisition = InternalRequisition::find($requisition_id);
            $status = Status::where('internal_requisition_id',$requisition_id)->first();
            $status->name = 'Internal Requisition';
            $comment = new Comment();
            $comment->internal_requisition_id =  $requisition_id ;
            $comment->type ='rejected';
            $comment->user_id = auth()->user()->id;
            $comment->comment =  "The internal reqsuisition was rejected by the Procurment Department.";
            $comment->save();
            $status->update();
            $user_group = array($commit->user_id,$budgetApprove->user_id,$approve->user_id,$internal_requisition->user_id);
            $users = User::whereIn('id',$user_group)->get();
            $users->each->notify(new RefuseInternalRequisitionPublish($internal_requisition,$comment));
            $approve->delete();
            $commit->delete();
            $budgetApprove->delete();

             return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }

    }
}
