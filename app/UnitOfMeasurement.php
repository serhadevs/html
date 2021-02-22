<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitOfMeasurement extends Model
{
    public function stocks(){
        return $this->hasOne('App\Stocks');
    }
}
