<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //
    use SoftDeletes;

   
   // protected $guarded = ['*'];
    protected $fillable = ['invoice_no','account_no','parish_code','value','institution_code','amount','payment_voucher_id'];
    
    public function paymentVoucher()
    {
        return $this->belongsTo('App\PaymentVoucher');
    }



}

