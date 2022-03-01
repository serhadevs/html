<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;

class UserRoles extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['user_id','role_id','primary'];

    public function role(){
        return $this->belongsTo('App\Role');
    } 

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
