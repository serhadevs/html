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
use App\Notifications\UpdateInternalRequisitionNotification;


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
            if (in_array(auth()->user()->role_id, [1,2,3,6,10,11,12,14,15]) OR in_array(2,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
            
            }
        });
    }
    public function index()
    {
        //
      if(in_array(auth()->user()->role_id,[1,10,11,12,15]))
      {

        if(auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,12,15])){
            $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','institution','department','approve_internal_requisition'])
            ->where(function($query){
                $query->whereHas('certified_internal_requisition',function($query){
                 $query->where('is_granted','=', 1);
                });
                $query->OrWhereHas('approve_internal_requisition',function($query){
                 $query->where('is_granted','=', 1);
                });
     
             })
              ->latest()
              ->get();
            
        }else{
            
        $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','institution','department','approve_internal_requisition'])
        ->where(function($query){
            $query->whereHas('certified_internal_requisition',function($query){
             $query->where('is_granted','=', 1);
            });
            $query->OrWhereHas('approve_internal_requisition',function($query){
             $query->where('is_granted','=', 1);
            });
 
         })
      ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
            
         })
         ->latest()
         ->get();
        }

      }else{
      $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','institution','department','certified_internal_requisition'])
      ->where(function($query){
        $query->where('department_id',auth()->user()->department_id)
        ->OrWhereIn('department_id',auth()->user()->accessDepartments_Id());
    })
    ->where(function($query){
        $query->where('institution_id','=',auth()->user()->institution_id)
        ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());

     })
      //where('department_id', auth()->user()->department_id)
      ->where(function($query){
           $query->whereHas('certified_internal_requisition',function($query){
            $query->where('is_granted','=', 1);
           });
           $query->OrWhereHas('approve_internal_requisition',function($query){
            $query->where('is_granted','=', 1);
           });

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

            $internalRequisition = InternalRequisition::find($request->data['internal_requisition_id']);
            if ($request->all()) {
                $approve = new ApproveInternalRequisition();
                $permission = $request->data['permission'];
                $approve->internal_requisition_id = $request->data['internal_requisition_id'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission;
                $approve->save();


               

                if($permission ===0){
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
        


                 ///if budget is already approve notify procurement
                }elseif($internalRequisition->approve_budget)
                 {
               
                    $users = User::where('institution_id', $internalRequisition->institution_id )
                    // ->where('department_id', auth()->user()->department_id)
                    ->whereIn('role_id',[9,12])
                    ->get();
                    $users->each->notify(new UpdateInternalRequisitionPublish($internalRequisition));
                    $add_role_user = User::user_with_roles($internalRequisition->institution_id,auth()->user()->department_id,9);
                    $add_role_user->each->notify(new UpdateInternalRequisitionNotification($internalRequisition));
                    
                
                //dd($users);
           
        
            
        
                }else{


                    $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                    if($status ===null){
                        $status = new Status();
                        $status->internal_requisition_id = $approve->internal_requisition_id;
                        $status->name = 'Internal Requisition Approved';
                        $status->save();

                    }else{
                    $status->name = ' Internal Requisition Approved';
                    $status->update();
                    }


                    if( $internalRequisition->department_id ===32){
                    $user = User::where('department_id',32)->where('role_id',8)->get();
                    $user->each->notify(new InternalRequisitionApprovePublish($internalRequisition));
    
                    }else{
                        
                        $user = User::where('institution_id',$internalRequisition->institution_id)->where('role_id',7)->get();
                        $user->each->notify(new InternalRequisitionApprovePublish($internalRequisition));
                $add_role_user = User::user_with_roles(auth()->user()->institution_id,auth()->user()->department_id,7);
                $add_role_user->each->notify(new InternalRequisitionApprovePublish($internalRequisition));
        
                    }
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
         // dd($internalRequisition->approve_internal_requisition->audits()->latest()->first());
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
           
            if ($internal->approve_budget && $internal->approve_internal_requisition->is_granted ===1) {
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
