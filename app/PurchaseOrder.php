<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Requisition;



class PurchaseOrder extends Model
{

  use SoftDeletes;


   protected $fillable = ['requisition_id','subtotal','trade_discount','freight','miscellaneous','tax','order_total','user_id'];

  public function requisition()
        {
          return  $this->belongsTo('App\Requisition');
        }

public function approvePurchaseOrder()
    {
        return $this->hasOne('App\ApprovePurchaseOrder');
    }
     
    
    public function user()
    {
        return $this->belongsTo('App\User')>withTrashed();
        
    }


    public function paymentVoucher()
    {
        return $this->hasOne('App\PaymentVoucher');
        
    }


   
    
  
}
