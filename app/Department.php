<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Department extends Model
{

    use SoftDeletes;

    public function institution(){
        return $this->belongsTo('App\Institution');
    } 
    public function unit(){
     return $this->hasOne(Unit::class,'department_id');
       // return $this->HasOne('App\Unit','id','department_id');
    } 
}
