<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Stock extends Model
{
    use SoftDeletes;
    protected $fillable = ['item_number','quantity','unit_of_measurement_id','description','unit_cost','part_number','internal_requisition_id'];
 


    public function unit_of_measurement(){
        return $this->belongsTo('App\UnitOfMeasurement');
    }

    public function stock_category(){
        return $this->belongsTo('App\StockCategory');



    }
    

    }