<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;




class Check extends Model
{
      // protected $guarded = ['*'];

      // protected $table = 'checks';
      use SoftDeletes;

    protected $fillable = ['is_check','is_refuse','requisition_id','user_id'];

     public function user(){
        return $this->belongsTo('App\User');
    }


    public function comment(){
      return $this->hasOne('App\Commnets');
  }



      
}
