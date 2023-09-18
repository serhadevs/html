<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;




class Department extends Model implements Auditable
{

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    public function institution(){
        return $this->belongsTo('App\Institution');
    } 
    public function unit(){
     return $this->hasOne(Unit::class,'department_id')->withTrashed();
       // return $this->HasOne('App\Unit','id','department_id');
    } 
}
