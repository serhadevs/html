<?php

use Illuminate\Database\Seeder;

class ParishTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parishes')->insert([


     [
    'name' => 'Regional Office',
    'abbr' => 'RO'
     ],
    [
    'name' => 'Kingston & ST.Andrew',
    'abbr' => 'KSA'
    ],
    [
    'name' => 'St Catherine',
    'abbr' => 'STC'
    ],
    [
    'name' => 'St Thomas',
    'abbr' => 'STT'
    ],
    [
    'name' => 'Kinston Public Hospital',
    'abbr' => 'KPH'
    ]

        ]);
    }
}
