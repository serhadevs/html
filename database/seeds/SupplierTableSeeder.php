<?php

use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('suppliers')->insert([
    [
    'name' => 'IGL',
    'supplier_code' => 'igl9908',
    'trn'=>'908678654',
    'address'=>'north street',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>'9088737878',
    ],
    [
    'name' => 'JN',
    'supplier_code' => 'JN99908',
    'trn'=>'908678654',
    'address'=>'west street',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>'908870878',
    ],
    [
   'name' => 'National',
    'supplier_code' => 'national9908',
    'trn'=>'908678654',
    'address'=>'north street',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>'90887237878',
    ],
    [
    'name' => 'SuperComputers',
    'supplier_code' => 'superl9908',
    'trn'=>'908678654',
    'address'=>'78 Oxford road',
    'city'=>'kingston',
    'parish_id'=>1,
    'country'=>'jamaica',
    'phone'=>'8760076654',
    'email'=>'90883377878',
    ]

        ]);
    }
    
}
