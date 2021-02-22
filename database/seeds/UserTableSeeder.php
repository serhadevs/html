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
            'department_id'=>1
            ],
            [
                'firstname'=>'Dan',
                'lastname'=>'Brown',
                'password'=>bcrypt('secret'),
                'telephone'=>'9088666',
                'email'=>'dbrown@gmail.com',
                'role_id'=>3,
                'institution_id'=>1,
                'department_id'=>1
            ]





        ]);
    }
}
