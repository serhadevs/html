<?php

use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        DB::table('units')->insert([

            [
            'name'=>'Mis',
            'department_id'=>1
            ],
            [
                'name'=>'stores',
                'department_id'=>2
            ],
           
            [
                'name'=>'Transport Unit',
                'department_id'=>2
            ],
            [
                'name'=>'Maintenance Engineer',
                'department_id'=>2
            ],
            [
                'name'=>'Pro',
                'department_id'=>3
                ],





        ]);
    }
}
