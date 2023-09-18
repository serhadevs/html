<?php

use Illuminate\Database\Seeder;

class ProcurementMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('procurement_methods')->insert([
    [
        "name" => "ICB",

    ],
    [
        "name" => "NCB",

    ],
    [
        "name" => "RB",

    ],
    [
        "name" => "SS",

    ],
     [
        "name" => "Emergency",

    ],

]);

    }
}
