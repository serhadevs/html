<?php

use Illuminate\Database\Seeder;

class RequisitionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('requisition_types')->insert([
    [
        "name" => "Goods",
        "code" => 7,


    ],
    [
        "name" => "Consulting Serivice",
          "code" => 6,

    ],
    [
        "name" => "Non-Consulting Serivice",
          "code" => 8,

    ],
    [
        "name" => "Works",
          "code" => 9,

    ],

]);

    }
}
