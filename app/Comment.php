<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
     use SoftDeletes;

    protected $fillable = ['check_id','type','comment'];


    public function check(){
        return $this->belongsTo('App\Check');
    }
}
