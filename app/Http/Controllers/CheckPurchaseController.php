<?php

namespace App\Http\Controllers;

use App\Check;
use App\Requisition;
use Illuminate\Http\Request;
// use App\Department;
// use App\Institution;
use DB;
// use App\Stock;
use App\Supplier;
// use App\StockCategory;
use App\InternalRequisition;
use App\User;
use App\Status;
use App\Approve;
use App\Comment;
use App\Notifications\AcceptRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;
use App\Notifications\ApproveRequisitionPublish;
use App\InstitutionTransfer;
use App\UnitOfMeasurement;


class CheckPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *Certify requisition page 
     * @return \Illuminate\Http\Response
     */

     public function __construct(Request $request)
    {

        $this->middleware('password.expired');

        $this->middleware(function ($request, $next) {
            if (in_array(auth()->user()->role_id, [1,3,5,6,9,10,12,15]) OR in_array(9,auth()->user()->userRoles_Id()->toArray()) OR in_array(5,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
               
            }
        });
    }

    public function index()
    {

        if (auth()->user()->institution_id === 1) {
    $requisitions = Requisition::with(['check','department','institution','supplier' ,'approve', 'purchase_order','store_approves','internalrequisition'])
         ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
         })
        ->withCount(['approve'=>function($query){
            $query->where('is_granted',1);
        }])
        ->Orwhere(function($query){
          $query->where('contract_sum','>',10000)
          ->having('approve_count','>',1)
          ->wherehas('check',function($query){
            $query->where('is_checked',1);
          })
          ->wherehas('internalrequisition',function($query){
            $query->where('currency_id','!=',1);  
          });
        
        })
        ->OrWhere(function($query){
            $query->having('approve_count','>',1)
            ->where('contract_sum','>',1500000)
            ->wherehas('check',function($query){
                $query->where('is_checked',1);
            });
        })
        ->latest()
        
        ->get();

        }else if(auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,6,12])){
            $requisitions = Requisition::with(['check','department','institution','supplier' ,'approve', 'purchase_order','store_approves','internalrequisition'])
            ->withCount(['approve'=>function($query){
                $query->where('is_granted',1);
            }])
            ->OrWhere(function($query){
                $query->having('approve_count','>',2);
            })
             ->latest()
             ->get();

            }else if(auth()->user()->institution_id === 0 AND !in_array(auth()->user()->role_id,[1,6,12])){
            
                $requisitions = Requisition::with(['check','department','institution','supplier' ,'approve', 'purchase_order','store_approves','internalrequisition'])
                ->where(function($query){
                    $query->where('institution_id','=',auth()->user()->institution_id)
                    ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
            
                 })
                 ->withCount(['approve'=>function($query){
                    $query->where('is_granted',1);
                }])
                ->OrWhere(function($query){
                    $query->having('approve_count','>',2);
                })
                 ->latest()
                 ->get();

              
      



} else {
    $requisitions = Requisition::with(['check','department','institution','supplier' ,'approve', 'purchase_order','store_approves','internalrequisition'])
       // ->Orwhere('contract_sum', '<', 250000)
        ->where(function($query){
            $query->where('institution_id','=',auth()->user()->institution_id)
            ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
    
         })
         ->withCount(['approve'=>function($query){
            $query->where('is_granted',1);
        }])
        ->OrWhere(function($query){
            $query->having('approve_count','>',2);
        })
        ->latest()
        ->get();
}


                // $comment = new Comment();
                // $comment->check_id = 1;
                // $comment->type ='accept';
                // $comment->comment = 'this was a rest';
                // $comment->save();
               // dd($comment);
   
        return view('/panel.check-purchase.index', ['requisitions' => $requisitions]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/panel.check-purchase.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $selected_items->data['appTypeId'];

try {

    
    
    if(isset($requisition->check)){
        if($requisition->check->user_id == auth()->user()->id){
            return 'fail';
        }
    }
    
    $is_checked = $request->data['checked'];
    $requisition = Requisition::find($request->data['requisitionId']);
    if($requisition->user_id === auth()->user()->id ){
        return 'fail';
    }

    
    if ($is_checked == 0) {
        //if already check\
        //remove already certify requisition
        $already_check = Check::where('requisition_id', $requisition->id);
        $already_check->delete();
        if(auth()->user()->institution_id === 1){
        $already_approve =Approve::where('requisition_id', $requisition->id);
        $already_approve->delete();
        }
        $check = new Check();
        $check->is_checked = $is_checked;
        $check->requisition_id = $request->data['requisitionId'];
        $check->user_id = auth()->user()->id;
        $check->save();
        
        $comment = new Comment();
        $comment->internal_requisition_id = $requisition->internal_requisition_id;
        $comment->type = 'refuse acceptance';
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->data['comment'];
        $comment->save();
        $status = Status::where('internal_requisition_id', $requisition->internal_requisition_id)->first();
        $status->name = 'Refuse Requisition';
        $status->update();

        
        $user = User::find($requisition->user_id);
        $user->notify(new RefuseRequisitionPublish($requisition, $comment));
        // $users->each->notify(new  RefuseRequisitionPublish($requisition,$comment ));

    } else {

        $check = new Check();
        $check->is_checked = $is_checked;
        $check->requisition_id = $request->data['requisitionId'];
        $check->user_id = auth()->user()->id;
        $check->save();
        $requisition = Requisition::find($request->data['requisitionId']);
    
        $requisition = Requisition::find($request->data['requisitionId']);
         if(auth()->user()->institution_id != $requisition->institution_id AND auth()->user()->institution_id ===1 ){
        $institute_tranfer = new InstitutionTransfer();
        $institute_tranfer->requisition_id = $requisition->id;
        $institute_tranfer->from = $requisition->institution_id;
        $institute_tranfer->to = auth()->user()->institution_id;
        $institute_tranfer->save();
        //change requisition location
        $requisition->institution_id = auth()->user()->institution_id;
        $requisition->update();
         //update requisition status
         $status = Status::where('internal_requisition_id', $requisition->internal_requisition_id)->first();
         $status->name = auth()->user()->institution->abbr.'Requisition Certify';
         $status->update();
         }else{
          //update requisition status
        $status = Status::where('internal_requisition_id', $requisition->internal_requisition_id)->first();
        $status->name = 'Requisition Certify';
        $status->update();   
        // $requisition->institution_id = auth()->user()->institution_id;
        // $requisition->update();
         }

        //delete or reset any approved requisition
        // if ($requisition->approve) {
        //     $approve = Approve::where('requisition_id', $requisition->id);
        //     $approve->delete();

        // }

        //notify primary institution users
        $users = User::where('institution_id', auth()->user()->institution_id)
            ->whereIn('role_id', [10,11,12])
            ->get();
        $requisition = Requisition::find($request->data['requisitionId']);
        $users->each->notify(new AcceptRequisitionPublish($requisition));
        //subscribe user institution notification
        $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[10,11,12]);
        $sub_users->each->notify(new AcceptRequisitionPublish($requisition));
        // $add_role_user = User::user_with_roles(auth()->user()->institution_id,auth()->user()->department_id,9);
        // $add_role_user->each->notify(new AcceptRequisitionPublish($requisition));
    }

    // if department head or super user automatic approve requisition
     if(in_array(auth()->user()->role_id,[10,11,12])){
        $approve = new Approve();
        $permission = 1;
        $approve->requisition_id=  $requisition->id;
        $approve->user_id = auth()->user()->id;
        $approve->is_granted = $permission;
        $approve->save();
        //status update
        $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
        $status->name = ' Requisition Approved ';
        $status->update();

        //notify primary institution users
        $users = User::where('institution_id',auth()->user()->institution_id )
        ->whereIn('role_id',[10,11,12])
        ->get();
    
        $users->each->notify(new ApproveRequisitionPublish($requisition));

        //subscribe user from other institution notification
        $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[10,12]);
        $sub_users->each->notify(new ApproveRequisitionPublish($requisition));

     }

    return 'success';

} catch (Exception $e) {
    return 'fail';
}
return redirect('/requisition')->with('status', 'Requisition was created successfully');


    }

 

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // $internal_requisition_id = Requisition::find($id)->pluck('internal_requisition_id');
       // dd(  $internal_requisition_id);
        $requisition=  Requisition::with('internalrequisition')->withCount('approve')->find($id);
       
        
       //dd($requisitions);
        return view('/panel.check-purchase.show',compact('requisition'));
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
            $requisition = Requisition::find($request->data['requisition_id']);
            $check = Check::where('requisition_id',$requisition->id)->first();
           
            if ($requisition->approve && !in_array(auth()->user()->role_id,[1,12,15])) {
                // if($internal->approve_internal_requisition->is_granted===1)
                return 'fail';
            }
            // $status = Status::where('requisition_id',$request->data['requisition_id'])->first();
            // $status->name = 'Requisition';
            // $status->update();
            $check->delete();
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
