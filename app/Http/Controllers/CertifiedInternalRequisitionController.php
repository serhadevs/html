<?php

namespace App\Http\Controllers;

use App\CertifiedInternalRequisition;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\Comment;
use App\User;
use App\Status;
use App\Notifications\CertifiedInternalRequisitionPublish;
use App\Notifications\RefuseInternalRequisitionPublish;



class CertifiedInternalRequisitionController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,2,10,11,13,14])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //

        if(in_array(auth()->user()->role_id,[1,2,10,11,12]))
        {
       
        if(auth()->user()->institution_id == 0 AND in_array(auth()->user()->role_id,[1,12])){
            $internalRequisitions = InternalRequisition::with(['user','certified_internal_requisition','institution','requisition_type'])->get();
            
        }else{
         
        $internalRequisitions = InternalRequisition::with(['user','certified_internal_requisition','institution','requisition_type'])
       // ->where('department_id',auth()->user()->department_id)
       ->where(function($query){
        $query->where('department_id',auth()->user()->department_id)
        ->OrWhereIn('department_id',auth()->user()->accessDepartments_Id());
    })
        ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
         ->Orwhere('user_id',auth()->user()->id)
        ->latest()
        ->get();
        }



        }else{
          
            $internalRequisitions = InternalRequisition::with(['user','certified_internal_requisition','institution','requisition_type'])
            // ->where('department_id',auth()->user()->department_id)
            ->where(function($query){
                $query->where('department_id',auth()->user()->department_id)
                ->OrWhereIn('department_id',auth()->user()->accessDepartments_Id());
            })
            //->whereIn('user_id',User::unitUsers()->pluck('id')->flatten())
            ->where(function($query){
                $query->whereIn('user_id',User::unitUsers()->pluck('id')->flatten())
                ->OrWhereIn('user_id',auth()->user()->accessUnits_Id());
            })
            ->where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
            
            ->latest()
            ->get();



        }
       //dd($internalRequisitions);

        return view('/panel/approve/certified-internal.index',compact('internalRequisitions'));
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
            if ($request->all()) {
                $approve = new CertifiedInternalRequisition();
                $permission = $request->data['permission'];
                $approve->internal_requisition_id = $request->data['internal_requisition_id'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission;
                $approve->save();


                if($permission ==0){
                    $comment = new Comment();
                    $comment->internal_requisition_id = $approve->internal_requisition_id;
                    $comment->type ='refuse certify requisition';
                    $comment->comment =  $request->data['comment'];
                    $comment->user_id = auth()->user()->id;
                    $comment->save();
    
                    $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                    $status->name = 'Internal Requisition rejected';
                    $status->update();
                    $internalrequisition = InternalRequisition::find($request->data['internal_requisition_id']);
                    $user = User::find($internalrequisition->user_id);
                    $user->notify(new RefuseInternalRequisitionPublish($internalrequisition,$comment));
                
        
            
        
                }else{

                    $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                    $status->name = 'Certified Internal Requisition';
                    $status->update();


                $users = User::where('institution_id',auth()->user()->institution_id )
                // ->where('department_id', auth()->user()->department_id)
                ->where(function($query){
                    $query->where('department_id',auth()->user()->department_id)
                    ->OrWhereIn('department_id',auth()->user()->accessDepartments_Id());
                })
                ->whereIn('role_id',[2])
                ->get();
                
               $internalRequisition = InternalRequisition::find($request->data['internal_requisition_id']);
            
               $users->each->notify(new CertifiedInternalRequisitionPublish($internalRequisition));

               
            }
            return 'success';
        }
        
        } catch (Exception $e) {
            return 'fail';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CertifiedInternalRequisition  $certifiedInternalRequisition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //
        $internalRequisition = InternalRequisition::with(['stocks','comment'])->find($id);
        //  dd( $internalRequisition);
        return view('/panel/approve/certified-internal.show', compact('internalRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CertifiedInternalRequisition  $certifiedInternalRequisition
     * @return \Illuminate\Http\Response
     */
    public function edit(CertifiedInternalRequisition $certifiedInternalRequisition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CertifiedInternalRequisition  $certifiedInternalRequisition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertifiedInternalRequisition $certifiedInternalRequisition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CertifiedInternalRequisition  $certifiedInternalRequisition
     * @return \Illuminate\Http\Response
     */

    public function undo(Request $request)
    {
        //
        try {
            $internal = InternalRequisition::find($request->data['certify_id']);
            $certified = CertifiedInternalRequisition::where('internal_requisition_id',$request->data['certify_id'])->first();
           
            if ($internal->approve_internal_requisition) {
                if($internal->approve_internal_requisition->is_granted===1)
                return 'fail';
            }
            $status = Status::where('internal_requisition_id',$request->data['certify_id'])->first();
            $status->name = 'Internal Requisition';
            $status->update();
            $certified->delete();
            return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }

    }


    public function destroy(CertifiedInternalRequisition $certifiedInternalRequisition)
    {
        //
    }
}
