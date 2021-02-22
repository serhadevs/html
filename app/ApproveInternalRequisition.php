<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApproveInternalRequisition extends Model
{
     

    protected $fillable = ['internal_requisition_id','is_granted','user_id'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
