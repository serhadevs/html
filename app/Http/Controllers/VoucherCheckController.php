<?php

namespace App\Http\Controllers;

use App\VoucherCheck;
use Illuminate\Http\Request;
use App\PaymentVoucher;
use App\Comment;
use App\User;
use App\Notifications\AcceptVoucherCheck;
use App\Notifications\RefuseVoucherCheck;


class VoucherCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
     //dd('test');   
        $vouchers = PaymentVoucher::all();
   
        return view('/panel.account.voucher-check.index',compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        

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
            $refuse =  $request->data['refuse'];
            $checked = $request->data['check'];
           // $com =$request->data['comment'];
            $check = new VoucherCheck();
            $check->is_check =  $checked;
            $check->is_refuse =  $refuse;
            $check->payment_voucher_id = $request->data['voucherId'];
            $check->user_id = auth()->user()->id;
            $check->save();
          
            if($refuse ==1){
                $comment = new Comment();
                $comment->check_id = $check->id;
                $comment->type ='voucher check';
                $comment->comment = $request->data['comment'];
                $comment->save();

                
                // $voucher = PaymentVoucher::find($request->data['voucherId']);
                // $user = User::find($voucher->purchaseOrder->user_id);
                // $user->notify(new RefuseVoucherCheck($voucher, $comment ));
            }else{

        // $requisition =  Requisition::find($request->data['requisitionId']);
        // $requisition->institution_id  = auth()->user()->institution_id;
        // $requisition->update();

        $users = User::where('institution_id',auth()->user()->institution_id )
        ->where('department_id', auth()->user()->department_id)
        ->whereIn('role_id',['1,7'])
        ->get();

        $voucher = PaymentVoucher::find($request->data['voucherId']);
            
         $users->each->notify(new AcceptVoucherCheck($voucher));
                return null;
           }
    
       
        return 'success';

       
    } catch (Exception $e) {
        return 'fail';
    }
    return redirect('/voucher-check')->with('status', 'Payment voucher was check');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VoucherCheck  $voucherCheck
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       // dd($voucherCheck);
        $voucher = PaymentVoucher::find($id);
       // dd($voucher);
        return view('/panel.account.voucher-check.show',compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VoucherCheck  $voucherCheck
     * @return \Illuminate\Http\Response
     */
    public function edit(VoucherCheck $voucherCheck)
    {
        //
        dd('edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VoucherCheck  $voucherCheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoucherCheck $voucherCheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VoucherCheck  $voucherCheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoucherCheck $voucherCheck)
    {
        //
    }
}
