<?php

namespace App\Http\Controllers;
use App\Requisition;
use App\Approve;
use DB;
use App\InternalRequisition;
use App\Notifications\ApproveRequisitionPublish;
use App\Notifications\RefuseRequisitionPublish;
use App\User;
use App\Comment;
use App\Check;
use App\Status;


use Illuminate\Http\Request;

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
            if (in_array(auth()->user()->role_id, [1,2,9,10,11,12]) OR in_array(9,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard')->with('error', 'Access Denied');
                
            }
        });
    }
    public function index()
    {
        //
  
      //  dd($approve);
      if (auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,12])) {

        $requisitions = Requisition::with(['check','approve'])
    
        //->where('department_id','=',auth()->user()->department_id)
          ->whereHas('check',function($query){
              $query->where('is_checked','=',1);
          })
          ->latest()
          ->get();

      }else{
      $requisitions = Requisition::with(['check','approve'])
    
    //->where('department_id','=',auth()->user()->department_id)
      ->whereHas('check',function($query){
          $query->where('is_checked','=',1);
      })
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
    if($requisition->check->user_id == auth()->user()->id AND !in_array(auth()->user()->role_id,[1,12]) ){
        return 'fail';
    }
    if ($request->all()) {
        $approve = new Approve();
        $permission = $request->data['permission'];
        $approve->requisition_id= $request->data['requisitionId'];
        $approve->user_id = auth()->user()->id;
        $approve->is_granted = $permission;
        $approve->save();

       



        if($permission ==0){
            

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


            
           
            
     

    

        }else{
            $status = Status::where('internal_requisition_id',$requisition->internal_requisition_id)->first();
            $status->name = ' Requisition Approved ';
            $status->update();
                //notify primary institution users
                $users = User::where('institution_id',auth()->user()->institution_id )
                ->whereIn('role_id',[9,12])
                ->get();

                $requisition = Requisition::find($request->data['requisitionId']);
            
                $users->each->notify(new ApproveRequisitionPublish($requisition));

                //subscribe user institution notification
                $sub_users = User::users_in_institution($requisition->institution_id)->whereIn('role_id',[9,12]);
                $sub_users->each->notify(new ApproveRequisitionPublish($requisition));
                $add_role_user = User::user_with_roles(auth()->user()->institution_id,auth()->user()->department_id,9);
                $add_role_user->each->notify(new ApproveRequisitionPublish($requisition));
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

//         // dd('test');
//         $stocks = DB::table('requisitions')
//     ->LeftJoin('suppliers', 'requisitions.supplier_id', '=', 'suppliers.id')
//     ->Join('stocks', function ($join) {
//         $join->on('stocks.requisition_id', '=', 'requisitions.id')
//             ->where('stocks.deleted_at', '=', null);

//     })
//     ->leftJoin('unit_of_measurements', 'unit_of_measurements.id', '=', 'stocks.unit_of_measurement_id')
//     ->leftJoin('departments', 'departments.id', '=', 'requisitions.department_id')
//     ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
//     ->leftJoin('stock_categories', 'stock_categories.id', '=', 'stocks.stock_category_id')
//     ->leftJoin('approves', 'approves.requisition_id', '=', 'requisitions.id')
//     ->leftJoin('checks', 'checks.requisition_id', '=', 'requisitions.id')
// // ->leftJoin('file__uploads','file__uploads.requisition_id','=','requisitions.id')

//     ->leftJoin('procurement_methods', 'procurement_methods.id', '=', 'procurement_method_id')
//     ->leftJoin('requisition_types', 'requisition_types.id', '=', 'requisitions.requisition_type_id')
// // ->leftJoin('stock_categories','stock_categories.id','=','requisitions.category_id')

//     ->leftJoin('users', 'users.id', '=', 'requisitions.user_id')
//     ->where('requisitions.id', $id)
// // ->where('stocks.deleted_at','=',null)
//     ->select('stocks.product_name', 'requisitions.*','checks.user_id as check_id' ,'approves.is_granted','approves.user_id as approve_id' ,'requisitions.description as des', 'requisition_types.name as type', 'procurement_methods.name as method', 'stocks.quantity', 'requisitions.cost_centre', 'requisitions.created_at', 'requisitions.total', 'stocks.description', 'stocks.unit_cost', 'unit_of_measurements.name as measurement', 'stock_categories.name as category',
//         'departments.name as department', 'institutions.name as institution', 'suppliers.name as supplier', 'suppliers.address as supplierAddress', 'users.firstname', 'users.lastname')
// // ->groupBy('file__uploads.requisition_id')
//     ->distinct('file__uploads.requisition_id')

//     ->get();



$requisition= Requisition::with('internalrequisition')->find($id);
//dd($requisition);
return view('/panel.approve.purchase-requisition.show', compact('requisition'));

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
            $approve = Approve::where('requisition_id',$requisition->id)->first();
           
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
    public function destroy($id)
    {
        //
    }
}
