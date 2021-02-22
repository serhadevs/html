<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AssignRequisition extends Model
{
    use SoftDeletes;

    protected $guarded = ['*'];


    public function internalRequisition()
    {
        return $this->hasOne('App\InternalRequisition');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }
 
}
