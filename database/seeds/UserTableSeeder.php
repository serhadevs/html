<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            [
            'firstname'=>'Dwayne',
            'lastname'=>'Beckett',
            'password'=>bcrypt('secret'),
            'telephone'=>'9088666',
            'email'=>'dwayneb@serha.gov.jm',
            'role_id'=>1,
            'institution_id'=>1,
            'department_id'=>1,
            'unit_id'=>1
            ],
            [
                'firstname'=>'Dwayne',
                'lastname'=>'Bailey',
                'password'=>bcrypt('password123'),
                'telephone'=>'9088666',
                'email'=>'dwaynerb@serha.gov.jm',
                'role_id'=>12,
                'institution_id'=>1,
                'department_id'=>3,
                'unit_id'=>3
            ]





        ]);
    }
}
