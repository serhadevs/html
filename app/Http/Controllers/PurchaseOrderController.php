<?php

namespace App\Http\Controllers;

use App\Approve;
use App\PurchaseOrder;
use App\Requisition;
use App\InternalRequisition;
use DB;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\PurchaseOrderPublish;
use App\Status;
use App\AttachedPurchaseOrder;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactSupplier;
use App\Events\NotificationPublished;


class PurchaseOrderController extends Controller
{
    /**implements ShouldQueue
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Request $request)
    {

        $this->middleware('password.expired');

        $this->middleware(function ($request, $next) {
            if (in_array(auth()->user()->role_id, [1,5,9,10,11,12,15]) OR in_array(5,auth()->user()->userRoles_Id()->toArray()) OR in_array(9,auth()->user()->userRoles_Id()->toArray())) {
                return $next($request);
            } else {
                return redirect('/dashboard');
            }
        });
    }
    public function index()
    {

        //aprove purchase requisition
        $requisitions = Requisition::with(['department','institution','supplier','check','approve','purchaseOrder','committee','user'])
            // ->where('institution_id', '=', auth()->user()->institution_id)
            ->where(function($query){
                $query->where('institution_id','=',auth()->user()->institution_id)
                ->OrWhereIn('institution_id',auth()->user()->accessInstitutions_Id());
        
             })
            ->whereHas('check', function ($query) {
                $query->where('is_checked', '=', 1);
            })
            ->whereHas('approve', function ($query) {
              
                $query->where('is_granted', '=', 1);
                $query->Orwhere('user_id',1);
                // $query->OrWhere(function($query){
                //     $query->where('user_id',1);
                // });
            })
            ->doesnthave('purchaseOrder')
            ->where(function($query){
                if(auth()->user()->institution_id !=1){
                 $query->where('contract_sum','<',1500000);
                }else{
                 $query->where('contract_sum','>',1)->where('contract_sum','<',1500000);
                 $query->OrwhereHas('entity_head_approve',function($query){
                    $query->where('is_granted',1);
                   });
                   $query->OrwhereHas('approve',function($query){
                       //or approve by RD
                    $query->where('user_id',1);
                   });
                }
             
            })
           
            ->latest()
            ->get();
          
           
       
        //purchaseOrder
 
        if (auth()->user()->institution_id === 0 AND !in_array(auth()->user()->role_id,[1,6,12,15])) {

            $purchase_orders = PurchaseOrder::with(['requisition','department','institution','supplier'])
            ->whereHas('requisition', function ($query) {
            $query->whereIn('institution_id',auth()->user()->accessInstitutions_Id()); 
            })
            ->latest()
            ->get();

         }elseif(auth()->user()->institution_id === 0 AND in_array(auth()->user()->role_id,[1,6,12,15]))
        {

            $purchase_orders = PurchaseOrder::with(['requisition'])
            ->whereHas('requisition', function ($query) {
            //$query->whereIn('institution_id',auth()->user()->accessInstitutions_Id()); 
            })
            ->latest()
            ->get();
        

            
        }else{
        $purchase_orders = PurchaseOrder::with(['requisition'])
            ->whereHas('requisition', function ($query) {
                $query->where('institution_id', '=', auth()->user()->institution_id)
                ->OrwhereIn('institution_id',auth()->user()->accessInstitutions_Id());
                
            })
            // ->doesnthave('budget_commitment')
            ->latest()
            ->get();
        }

     //   dd( $requisitions);

        return view('panel.purchase-order.index', compact('requisitions', 'purchase_orders'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        
        $requisition = Requisition::find($id);
        if($requisition->approve){
            // dd($requisition->approve->where('requisition_id',$id));
        $count = $requisition->approve->where('requisition_id',$id)->count();
        }
        // $count = $requisition->approve->where('requisition_id',$id)->count();

        return view('panel.purchase-order.create', ['count'=>$count,'requisition' => $requisition]);

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
       // dd($request->all());

        try {
            $request->validate([
                'purchase_order_no' => 'required',
                // 'order_total'=>'required',

            ]);
             //'pp_no' => 'required| max:30 |unique:infant_records,pp_no'
            $requisition_id = $request->id;
        //  dd( $request->all());
            if ($request->all()) {
                $purchaseorder = new PurchaseOrder();
                $purchaseorder->purchase_order_no = $request->purchase_order_no;
                $purchaseorder->comments = $request->comments;
                $purchaseorder->requisition_id = $request->id;
                $purchaseorder->requisition_no = $request->requisition_no;
                $purchaseorder->user_id = auth()->user()->id;

               
               if ($purchaseorder->save()) {

  
    

    if ($request->file('file_upload')) {
        $files = $request->file('file_upload');
        foreach ($files as $key => $file) {
            $newfile = new AttachedPurchaseOrder();
            if ($request->file('file_upload')) {
                $paths[] = $file->storeAs(
                    'public/documents', $file->getClientOriginalName()

                );

            }
            $newfile->filename = $file->getClientOriginalName();
            $newfile->purchase_order_id = $purchaseorder->id;
            $newfile->save();

       }

    }
    //update internal requisition status
$status = Status::where('internal_requisition_id', $purchaseorder->requisition->internal_requisition_id)->first();
$status->name = 'Purchase Order';
$status->update();
//dd($purchaseorder->requisition->supplier->email);

$user = User::find($purchaseorder->requisition->internalrequisition->user_id);
$user->notify(new PurchaseOrderPublish($purchaseorder));
// //notiffy supplier , requester, accounts and procurement team
$procurement_team = User::where('institution_id',auth()->user()->institution_id)->whereIn('role_id',[5,9])->pluck('id');
$users = User::whereIn('id',$procurement_team)->get();
$users->each->notify(new PurchaseOrderPublish($purchaseorder));

    Mail::to($purchaseorder->requisition->supplier->email)
    ->send(new ContactSupplier($purchaseorder));

    // event(new NotificationPublished($purchaseorder));
    



}


               
              
            

            }

        } catch (Exception $e) {
            return 'fail';
        }
        return redirect('/purchase-order')->with('status', 'Purchase Order was created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
      //  dd('test');
      $count = $purchaseOrder->requisition->approve->where('requisition_id',$purchaseOrder->requisition_id)->count();
      return view('/panel.purchase-order.show', compact('purchaseOrder','count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {

       


    //    $requisition = Requisition::find($purchaseOrder->requisition_id);
        //  dd($purchaseOrder->paymentVoucher->voucherCheck);
        // if ($purchaseOrder->paymentVoucher->voucherCheck->is_check==1) {
        //     return redirect('/purchase-order')->with('error', 'Purchase Order ' . $purchaseOrder->requisition->requisition_no . ' is already Accepted');
        // }

        // dd($requisition->stock);
        //     $purchase_order = DB::table('requisitions')
        //     ->left('purchase_order','purchase_order.requisition.id','=','requisitions.id')
        //     ->LeftJoin('suppliers', 'requisitions.supplier_id', '=', 'suppliers.id')
        //     ->leftJoin('stocks', 'stocks.requisition_id', '=', 'requisitions.id')
        //     ->leftJoin('unit_of_measurements', 'unit_of_measurements.id', '=', 'stocks.unit_of_measurement_id')
        //     ->leftJoin('departments', 'departments.id', '=', 'requisitions.department_id')
        //     ->leftJoin('institutions', 'institutions.id', '=', 'requisitions.institution_id')
        //     ->leftJoin('stock_categories', 'stock_categories.id', '=', 'stocks.stock_category_id')
        //     ->leftJoin('users', 'users.id', '=', 'requisitions.user_id')
        // // ->leftJoin('approves','approves.requisition_id','=','requisitions.id')
        // // ->where('purchase_order_id','=',1)

//     ->where('requisitions.id', $id)
        //     ->select('stocks.product_name', 'stocks.quantity', 'requisitions.id', 'requisitions.cost_centre', 'requisitions.created_at', 'requisitions.total', 'stocks.description', 'stocks.unit_cost', 'unit_of_measurements.name as measurement', 'stock_categories.name as category',
        //         'departments.name as department', 'institutions.name as institution', 'suppliers.name as supplier', 'suppliers.address as supplierAddress', 'users.firstname', 'users.lastname')
        //     ->get();
        $count = $purchaseOrder->requisition->approve->where('requisition_id',$purchaseOrder->requisition_id)->count();
        return view('panel.purchase-order.edit', compact('count','purchaseOrder'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
      // dd($request->all());
        try {
            $request->validate([
                'purchase_order_number' => 'required',
                // 'order_total'=>'required',

            ]);

            $purchaseOrder = PurchaseOrder::find($id);
            $purchaseOrder->purchase_order_no = $request->purchase_order_number;
            $purchaseOrder->comments = $request->comments;
            // $purchaseOrder->requisition_id = $request->requisition_id;
            // $purchaseOrder->subtotal = $request->subtotal;
            // $purchaseOrder->trade_discount = $request->trade_discount;
            // $purchaseOrder->freight = $request->freight;
            // $purchaseOrder->miscellaneous = $request->miscellaneous;
            // $purchaseOrder->tax = $request->tax;
            // $purchaseOrder->order_total = $request->order_total;
            // $purchaseOrder->user_id = auth()->user()->id;

            $purchaseOrder->update();

        } catch (Exception $e) {
            return 'fail';
        }

        return redirect('/purchase-order')->with('status', 'Purchase Order was updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
        $purchaseOrder= PurchaseOrder::find($id);
        $purchaseOrder->delete();
        return "success";
        } catch (Exception $e) {
            return 'fail';
        }
    }
}
