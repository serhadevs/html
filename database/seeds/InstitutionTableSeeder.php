<?php

use Illuminate\Database\Seeder;

class InstitutionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('institutions')->insert([
[
"name" => "Regional Office",
"abbr" => "RO",
"parish_id" => 1,
"code"=>1000
],
[
"name" => "National Chest Hospital",
"abbr" => "NCH",
"parish_id" => 2,
"code"=>3200
],
[
"name" => "Hope Institute",
"abbr" => "HI",
"parish_id" => 2,
"code"=>3400
],
[
"name" => "Sir John Golding",
"abbr" => "SJG",
"parish_id" => 2,
"code"=>3300
],
[
"name" => "St. Catherine Health Department",
"abbr" => "STCHD",
"parish_id" => 3,
"code"=>4300
],
[
"name" => "Spanish Town Hospital",
"abbr" => "STH",
"parish_id" => 3,
"code"=>4100
],
[
"name" => "Linstead Public Hospital",
"abbr" => "LPH",
"parish_id" => 3,
"code"=>4200
],
[
"name" => "St. Thomas Health Department",
"abbr" => "STTHD",
"parish_id" => 4,
"code"=>5200
],
[
"name" => "Princess Margaret Hospital",
"abbr" => "PMH",
"parish_id" => 4,
"code"=>5100
],
[
"name" => "KSA Health Department",
"abbr" => "KSAHD",
"parish_id" => 2,
"code"=>3500
],
[
"name" => "Bustamante Hospital for Children",
"abbr" => "BHC",
"parish_id" => 2,
"code"=>3100
],
[
"name" => "Kingston Public Hospital",
"abbr" => "KPH",
"parish_id" => 5,
"code"=>2100
],
[
"name" => "Victoria Jubilee Hospital",
"abbr" => "VJH",
"parish_id" => 5,
"code"=>2200
],


 ]);
    }
    }

