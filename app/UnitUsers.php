<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Unit;

class UnitUsers extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['user_id','unit_id','primary'];

    public function Unit(){
        return $this->belongsTo('App\unit');
    } 
}
