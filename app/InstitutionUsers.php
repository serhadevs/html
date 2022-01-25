<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Institution;

class InstitutionUsers extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['user_id','institution_id','primary'];

    public function institution(){
        return $this->belongsTo('App\Institution');
    } 
}
