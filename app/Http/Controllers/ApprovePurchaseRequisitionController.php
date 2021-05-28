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

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,2,9,10,11,12])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
  
      //  dd($approve);
      $requisitions = Requisition::with(['check','approve'])
      ->where('institution_id','=',auth()->user()->institution_id)
    ->where('department_id','=',auth()->user()->department_id)
      ->whereHas('check',function($query){
          $query->where('is_check','=',1);
      })
      ->get();

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

      
        try {
    if ($request->all()) {
        $approve = new Approve();
        $permission = $request->data['permission'];
        $approve->requisition_id= $request->data['requisitionId'];
        $approve->user_id = auth()->user()->id;
        $approve->is_granted = $permission;
        $approve->save();

        $requisition = Requisition::find($request->data['requisitionId']);



        if($permission ==0){
            

            $comment = new Comment();
            $comment->internal_requisition_id = $requisition->internal_requisition_id;
            $comment->type ='refuse requisition';
            $comment->comment =  $request->data['comment'];
            $comment->user_id = auth()->user()->id;
            $comment->save();

            $user = User::find($requisition->check->user_id);
            $user->notify(new RefuseRequisitionPublish($requisition,$comment));
            

            $acceptRequisition = Check::where('requisition_id',$requisition->id);
            $acceptRequisition->delete();


            
           
            
     

    

        }else{
            $status = Status::where('internal_requisition_id',$request->data['requisitionId'])->first();
            $status->name = 'Approved Requisition ';
            $status->update();

        $users = User::where('institution_id',auth()->user()->institution_id )
        ->where('department_id', auth()->user()->department_id)
        ->whereIn('role_id',[1,9,12])
        ->get();

                $requisition = Requisition::find($request->data['requisitionId']);
            
                $users->each->notify(new ApproveRequisitionPublish($requisition));
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
    public function destroy($id)
    {
        //
    }
}
