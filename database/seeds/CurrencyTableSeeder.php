<?php

use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('currencies')->insert([
    
            [
            'name' => 'Jamaican Dollar',
            'abbr' => 'JMD',
            ],
            [
            'name' => 'United States Dollar',
            'abbr' => 'USD',
         
            ]
        
            ]);
    }
}
