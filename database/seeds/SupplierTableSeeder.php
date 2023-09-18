<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
    DB::table('suppliers')->insert([
    [
    'name' => 'IGL',
    'supplier_code' => 'igl9908',
    'trn'=>'908678654',
    'address'=>'north street',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>$faker->unique()->safeEmail,
    ],
    [
    'name' => 'JN',
    'supplier_code' => 'JN99908',
    'trn'=>'908678654',
    'address'=>'west street',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>$faker->unique()->safeEmail,
    ],
    [
   'name' => 'National',
    'supplier_code' => 'national9908',
    'trn'=>'908678654',
    'address'=>'north street',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>$faker->unique()->safeEmail,
    ],
    [
    'name' => 'SuperComputers',
    'supplier_code' => 'superl9908',
    'trn'=>'908678654',
    'address'=>'78 Oxford road',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>$faker->unique()->safeEmail,
    ]

        ]);
    }
    
}
