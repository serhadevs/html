<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InternalRequisition extends Model
{
    //

    use SoftDeletes;

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

}
