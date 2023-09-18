<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

//approve requisition

class Approve extends Model implements Auditable
{

     use SoftDeletes;
     use \OwenIt\Auditing\Auditable;


    protected $fillable = ['requisition_id','is_granted','user_id'];

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }

    // public function approve_count($requisition_id){
    //     $approve_count = Approve::where('requisition_id',$requisition_id)->count();
    //     return $approve_count;

    // }

    public static function approve_list($requisition_id){
        $list = Approve::where('requisition_id',$requisition_id)->pluck('user_id');
        return $list;
    }
}
