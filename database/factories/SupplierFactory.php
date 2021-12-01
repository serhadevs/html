<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        
            'name' => $faker->name,
            'supplier_code' => Str::random(4),
            'trn'=>Str::random(9),
            'address'=>$faker->address,
            'city'=>$faker->name,
            'parish_id'=>1,
            'country'=>'jamaica',
            'phone'=>Str::random(10),
            'email'=>$faker->unique()->safeEmail,
            
    ];
});
