<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;



class Supplier extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


     public function parish(){
        return $this->BelongsTo('App\Parish');
    }
}
