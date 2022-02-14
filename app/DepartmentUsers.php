<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Department;


class DepartmentUsers extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['user_id','department_id','primary'];

    public function Department(){
        return $this->belongsTo('App\Department');
    } 
}
