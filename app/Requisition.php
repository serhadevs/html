<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;



class Requisition extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;



    protected $guarded = ['*'];

    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function purchase_order()
    {
        return $this->hasOne('App\PurchaseOrder');
    }

    // public function stock()
    // {
    //     return $this->hasMany('App\Stock');
    // }

    public function check()
    {
        return $this->hasOne('App\Check');
    }

    public function institution(){
        return $this->belongsTo('App\Institution');
    }
     public function department(){
        return $this->belongsTo('App\Department');
    }

    public function supplier(){
        return $this->belongsTo('App\Supplier');
    }

     public function requisition_type()
    {
        return $this->belongsTo('App\RequisitionType');
    }

    public function approve()
    {
        return $this->hasOne('App\Approve');
    }

    public function latest_approve()
    {
        return $this->hasOne('App\Approve')->latest();
    }
     

    public function procurement_method()
    {
        return $this->belongsTo('App\ProcurementMethod');

    }

    public function advertisement_method()
    {
        return $this->belongsTo('App\AdvertisementMethod');

    }
    public function category()
    {
        return $this->belongsTo('App\StockCategory');

    }

    public function files(){
        return $this->hasMany('App\File_Upload');

    }
    public function internalrequisition()
    {
        return $this->HasOne('App\InternalRequisition','id','internal_requisition_id');
    }

   public function purchaseOrder()
   {
       return $this->hasOne('App\PurchaseOrder');
   }

   public function store_approves()
   {
       return $this->hasOne('App\StoreApproves');
   }

   public function transfer(){
    return $this->hasOne('App\InstitutionTransfer');
   }

   public function committee(){
    return $this->hasOne('App\ProcurementCommittee');
   }
   
   public function entity_head_approve()
   {
       return $this->hasOne('App\EntityHeadApprove');
   }
   
}
