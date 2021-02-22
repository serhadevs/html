<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function department()
    {
        return $this->hasMany('App\Department');
    }
    public function parish()
    {
        return $this->BelongsTo('App\Parish');
    }
}
