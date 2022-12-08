<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;





class Check extends Model implements Auditable
{
      // protected $guarded = ['*'];

      // protected $table = 'checks';
      use SoftDeletes;
      use \OwenIt\Auditing\Auditable;


    protected $fillable = ['is_check','is_refuse','requisition_id','user_id'];

     public function user(){
        return $this->belongsTo('App\User')->withTrashed();
    }


    public function comment(){
      return $this->hasOne('App\Commnets');
  }



      
}
