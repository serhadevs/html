<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreApproves extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['requisition_id','date_approved','user_id','approve_id'];


    public function user(){
        return $this->belongsTo('App\User');
    }
}

