<?php

use Illuminate\Database\Seeder;

class UnitOfMeasurementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('unit_of_measurements')->insert([
    
    [
    'name' => 'each',
    'abbr' => 'ea',
    'description'=>'measurement of each item'
    ],
    [
    'name' => 'pack',
    'abbr' => 'pk',
    'description'=>'pack of'
    ],
    [
    'name' => 'gallon',
    'abbr' => 'gallon',
    'description'=>'gallon'
    ],
    [
    'name' => 'teaspoon',
    'abbr' => 'tea',
    'description'=>'table spoon'
    ],
    [
    'name' => 'litre',
    'abbr' => 'l',
    'description'=>'metric litre'
    ],
    [
    'name' => 'pound',
    'abbr' => 'lb',
    'description'=>'pound'
    ],
    [
    'name' => 'bottle',
    'abbr' => 'bt',
    'description'=>'bottle of'
    ],
    [
    'name' => 'roll',
    'abbr' => 'rl',
    'description'=>''
    ],
    [
    'name' => 'pair',
    'abbr' => 'pr',
    'description'=>''
    ],
    [
    'name' => 'box',
    'abbr' => 'bx',
    'description'=>''
    ],
    [
    'name' => 'keg',
    'abbr' => 'keg',
    'description'=>''
    ],
    [
    'name' => 'bucket',
    'abbr' => 'bk',
    'description'=>''
    ]

        ]);
    }
    }

