<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //

    public function requisition()
    {
        return $this->belongsTo('App\RequisitionType');
    }
}
