<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Institution extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


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
