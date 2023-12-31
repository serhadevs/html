<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class AssignRequisition extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    protected $guarded = ['*'];


    public function internalrequisition()
    {
        //return $this->hasOne('App\InternalRequisition');
        return $this->hasMany('App\InternalRequisition', 'id', 'internal_requisition_id');

    }


    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
 
}
