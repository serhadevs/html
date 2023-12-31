<?php

namespace App\Http\Controllers;

use App\ApproveBudget;
use App\InternalRequisition;
use Illuminate\Http\Request;
use App\Notifications\ApproveBudgetPublish;
use App\Notifications\RefuseInternalRequisitionPublish;
use App\User;
use PDF;
use App\Comment;
use App\Status;
class ApproveBudgetController extends Controller
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
            if (in_array(auth()->user()->role_id, [1,3,5,6,8,9,12,14,15]) OR in_array(8,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
            }
        });
    }
    public function index()
    {
        //
      

        if (auth()->user()->institution_id === 0) {
            $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','budget_commitment','institution','department','requisition_type'])
             ->whereHas('approve_internal_requisition',function($query){
             $query->where('is_granted','=', 1);
            })
            ->wherehas('budget_commitment',function($query){
             $query->where('deleted_at','=', null);
     
            })
            ->latest()
            ->get();

        }elseif(auth()->user()->department_id === 32){
            $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','budget_commitment','institution','department','requisition_type'])
            ->whereHas('approve_internal_requisition',function($query){
             $query->where('is_granted','=', 1);
            })
            ->wherehas('budget_commitment',function($query){
                $query->where('deleted_at','=', null);
        
               })
            ->where('department_id','=',32)
               ->where(function($query){
                 $query->where('institution_id','=',auth()->user()->institution_id)
                 ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
         
              })
            ->latest()
            ->get();

        }else{   
        $internalRequisitions = InternalRequisition::with(['user','approve_internal_requisition','budget_commitment','institution','department','requisition_type'])
       //->Orwhere('institution_id','=',auth()->user()->institution_id)
       //->whereIn('institution_id',auth()->user()->AccessInstitutions())
        ->whereHas('approve_internal_requisition',function($query){
        $query->where('is_granted','=', 1);
       })
       ->wherehas('budget_commitment',function($query){
        $query->where('deleted_at','=', null);

       })
     ->where(function($query){
        $query->where('institution_id','=',auth()->user()->institution_id)
        ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());

     })
    
     ->where('department_id','!=',32)
       ->latest()
       ->get();
    }

        return view('/panel/approve/budget.index',compact('internalRequisitions'));
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
            if(in_array(auth()->user()->role_id,[1,8,14]) OR in_array(8,auth()->user()->userRoles_Id()->toArray())  ){
                $approve = new ApproveBudget();
                $permission = $request->data['permission'];
                $approve->internal_requisition_id = $request->data['internal_requisition_id'];
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = $permission ;
                $approve->save();
                $internalrequisition = internalrequisition::find($request->data['internal_requisition_id']);
            
                if($permission ==0){
                    $comment = new Comment();
                    $comment->internal_requisition_id = $approve->internal_requisition_id ;
                    $comment->type ='budget refuse';
                    $comment->user_id = auth()->user()->id;
                    $comment->comment =  $request->data['comment'];
                    $comment->save();

                    //delete budget
                    $approve->delete();
                    //delete commitment
                    $internalrequisition->budget_commitment->delete();
                    //delete ipr approve
                    $internalrequisition-> approve_internal_requisition->delete();

                    

                    
                  
                    $user = User::find($internalrequisition->user_id);
                    $user->notify(new RefuseInternalRequisitionPublish($internalrequisition,$comment));
                 //  $users->each->notify(new  RefuseRequisitionPublish($requisition,$comment ));
                    $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                    $status->name = 'Budget rejected';
                    $status->update();

            

                }else{

                    //update requisition status
                $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
                $status->name = 'Budget Approved';
                $status->update();

                //notify procurement department
                $internalRequisition = InternalRequisition::find($request->data['internal_requisition_id']);
                $users = User::where('institution_id', $internalRequisition->institution_id )
                // ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id',[9,12])
                ->get();
                $users->each->notify(new ApproveBudgetPublish($internalRequisition));
                $add_role_user = User::user_with_roles($internalRequisition->institution_id,auth()->user()->department_id,9);
                $add_role_user->each->notify(new ApproveBudgetPublish($internalRequisition));


                

               
            }
            return 'success';
        }else{
            abort_if(in_array(auth()->user()->role_id,[2,5,12,9]),redirect('/panel/approve/budget.index')->with('error','No access granted'));
        }
        } catch (Exception $e) {
            return 'fail';
        }

        return redirect('/panel/approve/internal-requisition.index')->with('status', 'Budget was approve successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
         //
        $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
     
         return view('/panel/approve/budget.show', compact('internalRequisition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function edit(ApproveBudget $approveBudget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApproveBudget $approveBudget)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApproveBudget  $approveBudget
     * @return \Illuminate\Http\Response
     */

    public function printPDF($id)
    {
        $data = [
            'title' => 'First PDF for Medium',
            'heading' => 'South East Regional Health Authority',
            'heading2' => 'The Towers, 25 Dominica Drive, Kingston 5',
            'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'
        ];

         //
              $internalRequisition = InternalRequisition::with(['stocks'])->find($id);
              $pdf = PDF::loadView('/panel/approve/budget.pdf_view', $data,compact('internalRequisition')); 
              return $pdf->download('internalrequsisition'.$internalRequisition->requisition_no.'.pdf');
    }
    

    public function undo(Request $request)
    {
        //
        try {
            $internal = InternalRequisition::find($request->data['internal_requisition_id']);
            $approved = ApproveBudget::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
           
            if ($internal->requisition) {
                // if($internal->approve_internal_requisition->is_granted===1)
                return 'fail';
            }
            $status = Status::where('internal_requisition_id',$request->data['internal_requisition_id'])->first();
            $status->name = 'Approve Internal Requisition';
            $status->update();
            $approved->delete();
            return "success";
        
        } catch (Exception $e) {
            return 'fail';
        }

    }

    public function destroy(ApproveBudget $approveBudget)
    {
        //
    }   
}
