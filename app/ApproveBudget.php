<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApproveBudget extends Model
{
    //

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
