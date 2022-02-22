<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InternalRequisition;
use App\Stock;
use App\UnitOfMeasurement;
use App\ApproveInternalRequisition;
use App\Notifications\InternalRequisitionApprovePublish;
use App\User;
use App\Status;
use App\Comment;
use App\CertifiedInternalRequisition;

class ApproveInternalRequisitionController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,2,3,10,11,12,14])) {
                return redirect('/dashboard')->with('error', 'Access Denied');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
      if(in_array(auth()->user()->role_id,[1,10,11,12]))
      {

        if(auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,12])){
            $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','institution'])
            ->whereHas('certified_internal_requisition',function($query){
                 $query->where('is_granted','=', 1);
                })
              ->latest()
              ->get();
            
        }else{
            
        $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','institution'])
       ->whereHas('certified_internal_requisition',function($query){
            $query->where('is_granted','=', 1);
           })
      ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
            
         })
         ->latest()
         ->get();
        }

      }else{
      $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','institution'])
      ->where(function($query){
        $query->where('department_id',auth()->user()->department_id)
        ->OrWhereIn('department_id',auth()->user()->accessDepartments_Id());
    })
      //where('department_id', auth()->user()->department_id)
       ->whereHas('certified_internal_requisition',function($query){
            $query->where('is_granted','=', 1);
           })
      ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
         ->latest()
      
      ->get();
        }

    

        return view('/panel/approve/internal-requisition.index',compact('internalRequisitions'));

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
        //
        try {
            if ($request->all()) {
                $approve = new ApproveInternalRequisition();
                $permission = $request->data['permission'];
                $approve->internal_requisition_id = $request->data['internal_requisition_id'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission;
                $approve->save();


               

                if($permission ==0){
                    $comment = new Comment();
                    $comment->internal_requisition_id = $approve->internal_requisition_id;
                    $comment->type ='refuse internal requisition';
                    $comment->comment =  $request->data['comment'];
                    $comment->user_id = auth()->user()->id;
                    $comment->save();

                    $refuseIR=CertifiedInternalRequisition::where('internal_requisition_id',$request->data['internal_requisition_id']);
                    $refuseIR->delete();



    
                    
                    // $internalrequisition = InternalRequisition::find($request->data['internal_requisition_id']);
                    // $user = User::find($internalrequisition->user_id);
                    // $user->notify(new RefuseInternalRequisitionPublish($internalrequisition,$comment));
                    $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                    $status->name = ' Internal Requisition rejected';
                    $status->update();
        
            
        
                }else{
                    $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                    if(epmty($status)){
                        $status = new Status();
                        $status->internal_requisition_id = $internal_requisition->id;
                        $status->name = 'Internal Requisition Approved';
                        $status->save();

                    }else{
                    $status->name = ' Internal Requisition Approved';
                    $status->update();
                    }


                //notify primary facility users    
                $users = User::where('institution_id',auth()->user()->institution_id )
                ->whereIn('role_id',[7])
                ->get();
                
                $internalRequisition = InternalRequisition::find($request->data['internal_requisition_id']);
            
                $users->each->notify(new InternalRequisitionApprovePublish($internalRequisition));
                //subscribe user institution notification
                $sub_users = User::users_in_institution( $approve->internal_requisition_id )->whereIn('role_id',[7]);
                $sub_users->each->notify(new InternalRequisitionApprovePublish($internalRequisition));

               
            }
            return 'success';
        }
        
        } catch (Exception $e) {
            return 'fail';
        }

        return redirect('/panel/approve/internal-requisition.index')->with('status', 'Requisition was created successfully');
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
          $internalRequisition = InternalRequisition::with(['stocks','comment'])->find($id);
        //  dd( $internalRequisition);
        return view('/panel/approve/internal-requisition.show', compact('internalRequisition'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function undo(Request $request)
    {
        //
        try {
            $internal = InternalRequisition::find($request->data['internal_requisition_id']);
            $approve = ApproveInternalRequisition::where('internal_requisition_id',$internal->id)->first();
           
            if ($internal->approve_budget) {
               // if($internal->approve_internal_requisition->is_granted===1)
                return 'fail';
            }
            $status = Status::where('internal_requisition_id',$internal->id)->first();
            $status->name = 'Internal Requisition';
            $status->update();
            $approve->delete();
            return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }

    }

    public function destroy($id)
    {
        //
    }
}
