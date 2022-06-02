<?php

namespace App\Http\Controllers;

use App\EntityHeadApprove;
use Illuminate\Http\Request;
use App\Requisition;
use App\ProcurementCommittee;
use App\Notifications\ApproveRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;
use App\User;
use App\Comment;
use App\Check;
use App\Status;
//use App\Notifications\RequisitionPublish;


class EntityHeadApproveController extends Controller
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
            if (in_array(auth()->user()->role_id, [1,12,15])) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
            
            }
        });
    }
    public function index()
    {
        //

        $requisitions = Requisition::with(['check','approve','purchaseOrder','committee'])
        ->withCount('approve')
        // ->where(function($query){
        //     $query->where('institution_id','=',auth()->user()->institution_id)
        //     ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
        //  })
        ->whereHas('check', function ($query) {
            $query->where('is_checked', '=', 1);
        })
        ->whereHas('approve', function ($query) {
            $query->where('is_granted', '=', 1);
        })
        ->whereHas('committee', function ($query) {
            $query->where('action_taken_id', '=', 1);
        })
        ->doesnthave('purchaseOrder')
        ->where('contract_sum','>',1500000)
   
        // ->where(function($query){
        //     if(auth()->user()->institution_id ===1){
        //      $query->having('approve_count','>',1);
        //     }else{
        //      $query->having('approve_count','>',2);
        //     }
         
        // })
        ->latest()
        ->get();

      //  $requisition = Requisition::find(69);
       //dd(array($requisition->user_id,$requisition->internalrequisition->approve_budget->user_id,$requisition->approve->user_id,$requisition->internalrequisition->user_id));
        return view('/panel/approve/head_approve.index',compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            
            $requisition = Requisition::find($request->data['requisitionId']);
               // if approve exits
               // $approve = Approve::where('requisition_id',$request->data['requisitionId'])->get();
                $approve = new EntityHeadApprove();
                $permission = $request->data['permission'];
                $approve->requisition_id= $request->data['requisitionId'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission;
                $approve->save();
                
                if($permission == 0){
                    $comment = new Comment();
                    $comment->internal_requisition_id = $requisition->internal_requisition_id;
                    $comment->type ='refuse committee';
                    $comment->comment =  $request->data['comment'];
                    $comment->user_id = auth()->user()->id;
                    $comment->save();
        
                    //notify all stakeholder
                    $user_group = array($requisition->user_id,$requisition->internalrequisition->approve_budget->user_id,$requisition->approve->user_id,$requisition->internalrequisition->user_id);
                    $users = User::whereIn('id',$user_group)->get();
                    $users->each->notify(new RefuseRequisitionPublish($requisition,$comment));
                    $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
                    $status->name = ' Requisition refuse';
                    $status->update();
            
                    // $acceptRequisition = Check::where('requisition_id',$requisition->id);
                    // $acceptRequisition->delete();
        
                    //delete all approved requisition that approve by Senior managers
                        // $approves = Approve::where('requisition_id',$request->data['requisitionId'])->get();
                        // $approves->delete();
        
                    
        
                }else{
                    $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
                    $status->name = 'Entity Head Approved';
                    $status->update();
                    $users = User::where('institution_id','=',1)->whereIn('role_id',[5,9])->get();
                    $users->each->notify(new ApproveRequisitionPublish($requisition));
                    // dd($users);
                    
                }
                return 'success';
            
           
        
        } catch (Exception $e) {
            return 'fail';
        }
        return redirect('/entity_head_approve')->with('status', 'Approval was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EntityHeadApprove  $entityHeadApprove
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
      
        $requisition= Requisition::with(['internalrequisition','committee'])->withCount(['approve'])->find($id);

        return view('/panel/approve/head_approve.show', compact('requisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EntityHeadApprove  $entityHeadApprove
     * @return \Illuminate\Http\Response
     */
    public function edit(EntityHeadApprove $entityHeadApprove)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EntityHeadApprove  $entityHeadApprove
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntityHeadApprove $entityHeadApprove)
    {
        //
    }

    public function undo(Request $request)
    {
        //
        try {
            $requisition = Requisition::find($request->data['requisition_id']);
            $approve = EntityHeadApprove::where('requisition_id',$requisition->id)->orderBy('created_at','desc')->first();
            // $store_appove = StoreApproves::where('requisition_id',$requisition->id)->delete();
           
            if ($requisition->purchase_order) {
                // if($internal->approve_internal_requisition->is_granted===1)
                return 'fail';
            }
            $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
            $status->name = 'Requisition';
            $status->update();
            $approve->delete();
            
            return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EntityHeadApprove  $entityHeadApprove
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntityHeadApprove $entityHeadApprove)
    {
        //
    }
}
