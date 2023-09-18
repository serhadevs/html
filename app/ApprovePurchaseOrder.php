<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ApprovePurchaseOrder extends Model
{
    use SoftDeletes;

    protected $fillable = ['purchase_order_id','user_id','is_granted'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
