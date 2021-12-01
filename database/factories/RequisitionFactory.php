<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Requisition;
use Faker\Generator as Faker;

$factory->define(Requisition::class, function (Faker $faker) {
    return [
        
        'requisition_no' => "PO".Str::random(10),
        // 'requisition_type_id'=>rand(1, 4),
        'institution_id' => rand(1, 13),
        'department_id' => rand(1, 4),
        'cost_centre' => Str::random(10),
        'supplier_id' => rand(1, 4),
        'procurement_method_id'=>  rand(1, 4),
        'delivery'=>'COD',
        'description'=>$faker->name,
        'category_id'=>rand(1, 36),
        'tcc'=> $faker->randomDigit,
        'trn'=>$faker->randomDigit,
        'tcc_expired_date'=>$faker->date,
        // 'estimated_cost'=>$faker->randomDigit,
        'contract_sum'=>rand(10000,2000000),
        'cost_variance'=>$faker->randomDigit,
        // 'total'=>$faker->randomDigit,
        'user_id'=>1,
        // 'purchase_type' => $faker->name,
        'commitment_no' => rand(1, 10000),
        'internal_requisition_id' =>0,
        // 'prepare_by' => rand(1, 5),
        // 'stock_id' => rand(1, 10000),
        // 'check_id' => rand(1, 100),
        // 'date_ordered' => $faker->date,
        'date_require' => $faker->date,
        'date_last_ordered'=>$faker->date,
        'created_at'=>$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')
    ];
});












