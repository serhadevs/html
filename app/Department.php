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
}
