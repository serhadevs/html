<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class ApproveBudget extends Model implements Auditable
{
    //

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    public function user()
    {
        return $this->belongsTo('App\User')->withTrashed();
    }
}
