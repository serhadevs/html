<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use OwenIt\Auditing\Contracts\Auditable;


class InternalRequisition extends Model 
{
    //

    use SoftDeletes;
      // use \OwenIt\Auditing\Auditable;
    

    public function requisition()
    {
        return $this->hasOne('App\Requisition');
    }

    public function stocks()
    {
        return $this->hasMany('App\Stock');
    }
     public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function institution(){
        return $this->belongsTo('App\Institution');
    }
     public function department(){
        return $this->belongsTo('App\Department');
    }

    public function requisition_type()
    {
        return $this->belongsTo('App\RequisitionType');
    }

    public function approve_internal_requisition()
    {
        return  $this->hasOne('App\ApproveInternalRequisition');
    }

    public function certified_internal_requisition()
    {
        return  $this->hasOne('App\CertifiedInternalRequisition');
    }

    public function status()
    {
        return  $this->hasOne('App\Status');
    }

    public function budget_commitment()
    {
        return  $this->hasOne('App\BudgetCommitment');
    }

    public function approve_budget()
    {
        return  $this->hasOne('App\ApproveBudget');
    }

    public function assignto()
    {
        return  $this->hasOne('App\AssignRequisition');
    }

    public function comment()
    {
        return  $this->hasMany('App\Comment');
    }

}
