<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VoucherCheck extends Model
{
    //

    use SoftDeletes;
    protected $fillable = ['is_check','is_refuse','payment_voucher_id','user_id'];


    public function user(){
        return $this->belongsTo('App\User');
    }


    public function paymentVoucher(){
        return $this->belongsTo('App\PaymentVoucher');
    }



}
