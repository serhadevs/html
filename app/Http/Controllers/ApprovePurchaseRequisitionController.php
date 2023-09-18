<?php

namespace App\Http\Controllers;
use App\Requisition;
use App\Approve;
use DB;
use App\InternalRequisition;
use App\Notifications\ApproveRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;
use App\Notifications\AcceptRequisitionPublish;
use App\Notifications\RequisitionPublish;
use App\User;
use App\Comment;
use App\Check;
use App\Status;
use App\StoreApproves;


use Illuminate\Http\Request;
ini_set('upload_max_filesize', '400M');
ini_set('post_max_size', '400M');


class ApprovePurchaseRequisitionController extends Controller
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
            if (in_array(auth()->user()->role_id, [1,6,9,10,11,12,15]) OR in_array(9,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
                
            }
        });
    }
    public function index()
    {
        //
        // $approve = Approve::approve_list(150)->toArray();
        // dd($approve);
      if (auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,12])) {

        $requisitions = Requisition::with(['check','approve','department','institution','internalrequisition','supplier'])
        ->withCount('approve')
        //->where('department_id','=',auth()->user()->department_id)
          ->whereHas('check',function($query){
              $query->where('is_checked','=',1);
          })
          ->latest()
          ->get();

      }else{
      $requisitions = Requisition::with(['check','approve','department','institution','internalrequisition','supplier'])
    
       ->withCount('approve')
      ->whereHas('check',function($query){
          $query->where('is_checked','=',1);
      })
    // ->OrWhere(function($query){
    //     $query->having('approve_count','>',2)->where('contract_sum','>',500000)
    //     ->having('check_count','>',2);
    // })
      ->where(function($query){
        $query->where('institution_id','=',auth()->user()->institution_id)
        ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
     })
    
      ->latest()
      ->get();
    }
      // dd($requisitions);
        return view('/panel/approve/purchase-requisition.index',compact('requisitions') );


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        
        return view('/panel/approve/purchase-requisition.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //no same person can approve and accept requisition
        
      
        try {

            
    $requisition = Requisition::find($request->data['requisitionId']);
    $count = 0;
    if(isset($requisition->approve)){
    $count = $requisition->approve->where('requisition_id',$request->data['requisitionId'])->count();
    }else{
    $count = 0;
    }
   // $count = 2 ;
    if($requisition->check->user_id == auth()->user()->id AND !in_array(auth()->user()->role_id,[1,10,11,12,15]) ){
        return 'fail';
    }
     
    $approve_list = Approve::approve_list($requisition->id)->toArray();
    if(in_array(auth()->user()->id,$approve_list )){
        return  'fail';
    }

    if(in_array(auth()->user()->role_id,[6,9])){
        return  'fail';
    }
    if ($request->all()) {

       // if approve exits
       // $approve = Approve::where('requisition_id',$request->data['requisitionId'])->get();
      
       
        $approve = new Approve();
        $permission = $request->data['permission'];
        $approve->requisition_id= $request->data['requisitionId'];
        $approve->user_id = auth()->user()->id;
        $approve->is_granted = $permission;
        $approve->save();
        if($permission ===0){
            

            $comment = new Comment();
            $comment->internal_requisition_id = $requisition->internal_requisition_id;
            $comment->type ='refuse requisition';
            $comment->comment =  $request->data['comment'];
            $comment->user_id = auth()->user()->id;
            $comment->save();

            $user = User::find($requisition->check->user_id);
            $user->notify(new RefuseRequisitionPublish($requisition,$comment));
            $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
            $status->name = ' Requisition refuse';
            $status->update();
            

            $acceptRequisition = Check::where('requisition_id',$requisition->id);
            $acceptRequisition->delete();

            //delete all approved requisition that approve by Parish manager
            if(in_array(auth()->user()->role_id,[10,11])){
                $approves = Approve::where('requisition_id',$request->data['requisitionId'])->get();
                $approves->delete();

            }

        }else{
            $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
            $status->name = ' Requisition Approved ';
            $status->update();

            $approve = Approve::where('requisition_id',$requisition->id)->get();
            if($count ===1 AND $requisition->contract_sum > 1500000 AND !auth()->user()->institution_id !=1) {
           // store approve data b4 transfer
                foreach ($approve as $key => $store) {
                    $app_store = StoreApproves::create([
                        'requisition_id' => $store->requisition_id,
                        'date_approved' => $store->created_at,
                        'approve_id' => $store->id,
                        'user_id' => $store->user_id,
                    ]);
                }
            //change check should be null but store pass certying officer
             //Approve::where('requisition_id',$requisition->id)->delete();
            }
           
         // approve by health departments
            if(in_array(auth()->user()->institution_id,[1,5,8,10,12]))
            {
               

               //notify health departments users
                if($requisition->contract_sum < 1500000){    
                $users = User::where('institution_id','=',$requisition->institution_id)->whereIn('role_id',[5,9])->get();
                $users->each->notify(new ApproveRequisitionPublish($requisition));
                $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[9,5]);
                $sub_users->each->notify(new ApproveRequisitionPublish($requisition));
                }else{
                    //notifify regional office procurement users
                    $users = User::where('institution_id','=',1)->whereIn('role_id',[5,9,12])->get();
                    $users->each->notify(new RequisitionPublish($requisition));

                }







            }else{
                //approve by institutions
            if($count === 1 AND $requisition->contract_sum < 1500000){
                
            //notify primary institution procurement users
            $users = User::where(function($query){
                $query->where('institution_id','=',$requisition->institution_id);
        
             })
                ->whereIn('role_id',[5,9])
                ->get();
            $users->each->notify(new ApproveRequisitionPublish($requisition));
            $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[9,5]);
            $sub_users->each->notify(new ApproveRequisitionPublish($requisition));
            }else if($count === 0  AND $requisition->contract_sum < 1500000)
            {
                //notify institute ceo
                $users = User::where('institution_id','=',auth()->user()->institution_id)->whereIn('role_id',[11])->get();
    
                $users->each->notify(new AcceptRequisitionPublish($requisition));
                $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[11]);
                $sub_users->each->notify(new AcceptRequisitionPublish($requisition));
            }else if ($requisition->contract_sum >= 1500000){

            //notify primary regional office users
            $users = User::where('institution_id','=',1)->whereIn('role_id',[5,9,12])->get();
            $users->each->notify(new RequisitionPublish($requisition));
            // $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[5,9]);
            // $sub_users->each->notify(new AcceptRequisitionPublish($requisition));
    



            }
        }
                
                // $requisition = Requisition::find($request->data['requisitionId']);
            
                

                // //subscribe user institution notification
                // $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[10,11,12]);
                // $sub_users->each->notify(new AcceptRequisitionPublish($requisition));
                // // $add_role_user = User::user_with_roles(auth()->user()->institution_id,auth()->user()->department_id,9);
                // // $add_role_user->each->notify(new ApproveRequisitionPublish($requisition));
        }
        return 'success';
    }
   

} catch (Exception $e) {
    return 'fail';
}
return redirect('/purchase-requisition')->with('status', 'Requisition was created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



$count = 0;
$requisition= Requisition::with(['internalrequisition'])->withCount(['approve'])->find($id);
// dd($requisition);
if($requisition->approve){
    // dd($requisition->approve->where('requisition_id',$id));
$count = $requisition->approve->where('requisition_id',$id)->count();
}

return view('/panel.approve.purchase-requisition.show', compact('requisition','count'));

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
            $approve = Approve::where('requisition_id',$requisition->id)->orderBy('created_at','desc')->first();
            $store_appove = StoreApproves::where('requisition_id',$requisition->id)->delete();
           
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
    
}
