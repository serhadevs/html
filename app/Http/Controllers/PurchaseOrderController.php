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

class PurchaseOrderController extends Controller
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
            if (!in_array(auth()->user()->role_id, [1,5,9,12])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {

        //aprove purchase requisition
        $requisitions = Requisition::with(['check','approve','purchaseOrder'])
            ->where('institution_id', '=', auth()->user()->institution_id)
            ->whereHas('check', function ($query) {
                $query->where('is_check', '=', 1);
            })
            ->whereHas('approve', function ($query) {
                $query->where('is_granted', '=', 1);
            })
            ->doesnthave('purchaseOrder')

            ->get();

        //purchaseOrder

        $purchase_orders = PurchaseOrder::with(['requisition'])
            ->whereHas('requisition', function ($query) {
                $query->where('institution_id', '=', auth()->user()->institution_id);
            })
            // ->doesnthave('budget_commitment')
            ->get();

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
        

        return view('panel.purchase-order.create', ['requisition' => $requisition]);

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
          //dd( $request->all());
            if ($request->all()) {
                $purchaseorder = new PurchaseOrder();
                $purchaseorder->purchase_order_no = $request->purchase_order_no;
                $purchaseorder->comments = $request->comments;
                $purchaseorder->requisition_id = $request->id;
                $purchaseorder->requisition_no = $request->requisition_no;
                $purchaseorder->user_id = auth()->user()->id;

               $purchaseorder->save();

               //update internal requisition status
               $status = Status::where('internal_requisition_id',$purchaseorder->requisition->internal_requisition_id)->first();
                $status->name = 'Purchase Order';
                $status->update();
               
                $users = User::where('institution_id',auth()->user()->institution_id )
                ->where('department_id', auth()->user()->department_id)
                ->whereIn('role_id',[1,9,12])
                ->get();
                //dd($internal_requisition);
                $users->each->notify(new PurchaseOrderPublish($purchaseorder));
              
            

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
        dd('test');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {

     //dd($purchaseOrder->paymentVoucher->voucherCheck);
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
        return view('panel.purchase-order.edit', compact('purchaseOrder'));

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
