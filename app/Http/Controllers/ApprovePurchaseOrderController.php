<?php

namespace App\Http\Controllers;
use App\PurchaseOrder;
use App\Requisition;
use App\ApprovePurchaseOrder;
use Illuminate\Http\Request;

class ApprovePurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request)
    {

        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role_id, [1,2])) {
                return redirect('/dashboard');
            } else {
                return $next($request);
            }
        });
    }
    public function index()
    {
        //
        // $approvePurchaseOrder =new ApprovePurchaseOrder();
        //  dd($approvePurchaseOrder);
        $purchaseOrders = PurchaseOrder::with(['requisition'])
        ->whereHas('requisition',function($query){
        $query->where('institution_id','=', auth()->user()->institution_id);
    })
    // ->whereHas('approvePurchaseOrder', function ($query) {
    //     $query->where('is_granted', '=', true);
      



    ->get();

        

       //dd($purchaseOrder);
        return view('/panel/approve/purchase-order.index',compact('purchaseOrders'));

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
        $approve = new ApprovePurchaseOrder();
      //dd($approve );
        $approve->purchase_order_id = $request->data['purchase_id'];
        $approve->user_id = auth()->user()->id;
        $approve->is_granted = true;
        $approve->save();
    }
    return 'success';

} catch (Exception $e) {
    return 'fail';
}
return redirect('/approve-purchase-order')->with('status', 'Requisition was created successfully');

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
        $purchase_order = PurchaseOrder::find($id);
        $requisition = Requisition::find($purchase_order->requisition_id);

     return view('/panel.approve.purchase-order.show',compact('purchase_order','requisition'));


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
