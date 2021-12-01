<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BudgetCommitment extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    

    protected $guarded = ['*'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function internalrequisition()
    {
        return $this->HasOne('App\InternalRequisition','id','internal_requisition_id');
    }

    // public function approve_budget()
    // {
    //     return  $this->hasOne('App\ApproveBudget');
    // }

}
