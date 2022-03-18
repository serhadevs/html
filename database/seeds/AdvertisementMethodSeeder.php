<?php

use Illuminate\Database\Seeder;

class AdvertisementMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('advertisement_methods')->insert([
            [
                "name" => "Notice Board",
        
            ],
            [
                "name" => "National Advertisement",
        
            ],
            [
                "name" => "International Advertisement",
        
            ],
            [
                "name" => "GOJEP",
        
            ],
            
        
        ]);
    }
}
