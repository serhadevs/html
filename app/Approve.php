<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//approve requisition

class Approve extends Model
{

     use SoftDeletes;

    protected $fillable = ['requisition_id','is_granted','user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
