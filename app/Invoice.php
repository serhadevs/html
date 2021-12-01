<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;



class Invoice extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


   
   // protected $guarded = ['*'];
    protected $fillable = ['invoice_no','account_no','parish_code','value','institution_code','amount','payment_voucher_id'];
    
    public function paymentVoucher()
    {
        return $this->belongsTo('App\PaymentVoucher');
    }



}

