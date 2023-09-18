<?php

namespace App\Http\Controllers;

use App\PaymentVoucher;
use Illuminate\Http\Request;
use App\PurchaseOrder;
use App\Invoice;



class PaymentVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $purchaseOrders = PurchaseOrder::with(['paymentVoucher','requisition'])
        ->doesnthave('paymentVoucher')
        ->whereHas('requisition', function ($query) {
            $query->where('delivery', '=', 'cod');
        })
        ->get();
        $vouchers = PaymentVoucher::all();

       // dd($vouchers);


        return view('/panel.account.payment-voucher.index',compact('purchaseOrders','vouchers'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
       $purchaseOrder = PurchaseOrder::find($id);

        return view('/panel.account.payment-voucher.create',compact('purchaseOrder'));
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

         //dd($request->all());

 

            $payment_voucher = new PaymentVoucher();
            $payment_voucher->cheque_no= $request->cheque_no;
            $payment_voucher->cheque_date = $request->cheque_date;
            $payment_voucher->voucher_no= $request->cheque_no;
            $payment_voucher->voucher_date = $request->cheque_date;
            $payment_voucher->purchase_order_id =$request->purchase_order_id;
            $payment_voucher->description = $request->description;
            $payment_voucher->amount_in_words = $request->amount_in_words;
            $payment_voucher->user_id = auth()->user()->id;
            // $payment_voucher->save();

            if ( $payment_voucher->save()) {

                $input = $request->all();
               
                 if ($input['invoice_num'][0]) {
                    foreach ($input['invoice_num'] as $key => $invoice) {
                            $invoice = Invoice::create([
                            'invoice_no' => $input['invoice_num'][$key],
                            'parish_code' => $input['parish_code'][$key],
                            'institution_code' => $input['institution_code'][$key],
                            'value' => $input['value'][$key],
                            'account_no' => $input['account_num'][$key],
                            'amount' => $input['amount'][$key],
                            'payment_voucher_id' => $payment_voucher->id,
                        ]);
                       
                    }
             
                } 
    
            }


            return redirect('/payment-voucher')->with('status', 'Payment voucher was created successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PaymentVoucher  $paymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentVoucher $paymentVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PaymentVoucher  $paymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentVoucher $paymentVoucher)
    {
        //
    //    dd($paymentVoucher->invoices);
    if ($paymentVoucher->voucherCheck->is_check==1) {
        return redirect('/payment-voucher')->with('error', 'Payment Voucher ' . $paymentVoucher->voucher_no . ' is already Accepted');
    }
    
        return view('/panel.account.payment-voucher.edit', compact('paymentVoucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PaymentVoucher  $paymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentVoucher $paymentVoucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PaymentVoucher  $paymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $payment_voucher = PaymentVoucher::with(['invoices'])->find($id);
            $payment_voucher->delete();

            $invoices = Invoices::where('payment_voucher_id',$id)->get();
            $invoices->each->delete();
            


            
            return "success";
        } catch (Exception $e) {
            return 'fail';
        }
    }
}
