<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentVoucher extends Model
{
    //
 use SoftDeletes;
 protected $guarded = ['*'];



    public function purchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder');
    } 



    public function invoices(){
        return $this->hasMany('App\Invoice');
    }


    public function voucherCheck(){
        return $this->hasOne('App\VoucherCheck');
    }

    public function certifyingVoucher(){
        return $this->hasOne('App\CertifyingPaymentVoucher');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
        
    }
}
