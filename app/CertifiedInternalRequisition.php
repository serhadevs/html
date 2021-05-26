<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertifiedInternalRequisition extends Model
{
    //

    protected $fillable = ['internal_requisition_id','is_granted','user_id'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
