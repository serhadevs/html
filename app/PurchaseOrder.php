<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Requisition;
use OwenIt\Auditing\Contracts\Auditable;




class PurchaseOrder extends Model implements Auditable
{

  use SoftDeletes;
  use \OwenIt\Auditing\Auditable;



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
        return $this->belongsTo('App\User')->withTrashed();
        
    }


    public function paymentVoucher()
    {
        return $this->hasOne('App\PaymentVoucher');
        
    }

     public function attached(){
        return $this->hasMany('App\AttachedPurchaseOrder');

    }
   
    
  
}
