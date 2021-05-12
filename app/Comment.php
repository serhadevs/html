<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
     use SoftDeletes;

    protected $fillable = ['check_id','type','comment'];


   


    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function internalrequisition()
    {
        return $this->HasMany('App\InternalRequisition','id','internal_requisition_id');
    }
}
