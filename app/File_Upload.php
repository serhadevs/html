<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;



class File_Upload extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


}
