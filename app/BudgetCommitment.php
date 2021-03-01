<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BudgetCommitment extends Model
{
    //
    use SoftDeletes;

    protected $guarded = ['*'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function internalrequisition()
    {
        return $this->HasOne('App\InternalRequisition','id','internal_requisition_id');
    }
}
