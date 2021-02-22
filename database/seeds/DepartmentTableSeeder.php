<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
    [

        "name" => "MIS",
        "abbr" => "mis",

    ],

    [
        "name" => "Operations & Maintenance",
        "abbr" => "op",

    ],
    [
        "name" => "Procurement Dept.",
        "abbr" => "procure",

    ],
    [
        "name" => "Projects",
        "abbr" => "proj",

    ],
    [
        "name" => "Finance Dept",
        "abbr" => "acc",

    ],
    [
        "name" => "HIV/STI",
        "abbr" => "hiv",

    ],
    [
        'name' => 'Human Resource & Industrial Relation',
        'abbr' => 'HR',

    ],
    [
        'name' => 'Internal Auditors',
        'abbr' => 'IA',

    ],
    [
        'name' => 'Payables',
        'abbr' => 'pay',

    ],
    [
        'name' => 'Payroll Dept.',
        'abbr' => 'payroll',

    ],
    [
        'name' => 'Technical Dept.',
        'abbr' => 'Tech',

    ],
    [
        'name' => 'Disbursement & Final Account',
        'abbr' => 'HR',

    ],
    [
        'name' => 'Industrial Relation',
        'abbr' => 'IR',

    ],

]);

    }
}
