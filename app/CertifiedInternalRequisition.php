<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class CertifiedInternalRequisition extends Model implements Auditable
{
    //
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = ['internal_requisition_id','is_granted','user_id'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
