<?php

namespace App\Http\Controllers;

use App\CertifyingPaymentVoucher;
use Illuminate\Http\Request;
use App\PaymentVoucher;


class CertifyingPaymentVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd('test');
        $payment_vouchers = PaymentVoucher::with(['voucherCheck'])
       // ->whereHas('voucherCheck')
        ->whereHas('voucherCheck',function($query){
            $query->where('is_check','=', 1);
           })
        ->get();

       // dd($payment_voucher );

        return view('/panel.approve.certifying.index',compact('payment_vouchers'));
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
        //

        try {
            if ($request->all()) {
                $approve = new CertifyingPaymentVoucher();
               // $approve->requisition_type = 1;
                $approve->payment_voucher_id= $request->data['voucherId'];
                // $approve->purchase_order_id = null;
                $approve->user_id = auth()->user()->id;
                $approve->is_granted = true;
                // $approve->approve_date=now();
        
        
                $approve->save();
        
                // $users = User::where('institution_id',auth()->user()->institution_id )
                // ->where('department_id', auth()->user()->department_id)
                // ->whereIn('role_id',['1,5,2'])
                // ->get();
        
                      //  $requisition = Requisition::find($request->data['requisitionId']);
                    
                       // $users->each->notify(new ApproveRequisitionPublish($requisition));
            }
            return 'success';
        
        } catch (Exception $e) {
            return 'fail';
        }
        return redirect('/purchase-requisition')->with('status', 'Payment Voucher was certified successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CertifyingPaymentVoucher  $certifyingPaymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $certifyingPaymentVoucher = PaymentVoucher::find($id);
       // dd($certifyingPaymentVoucher);


        return view('/panel.approve.certifying.show',compact('certifyingPaymentVoucher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CertifyingPaymentVoucher  $certifyingPaymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit(CertifyingPaymentVoucher $certifyingPaymentVoucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CertifyingPaymentVoucher  $certifyingPaymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertifyingPaymentVoucher $certifyingPaymentVoucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CertifyingPaymentVoucher  $certifyingPaymentVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertifyingPaymentVoucher $certifyingPaymentVoucher)
    {
        //
    }
}
