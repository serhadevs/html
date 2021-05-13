<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 DB::table('roles')->insert([
[
"name" => "Super Admin",
"description" => "Highest Level"
],
[
"name" => "Manager",
"description" => "High Level"
],
[
"name" => "Admin",
"description" => "Mid Level"
],
[
"name" => "User",
"description" => "Low Level"
],
[
"name" => "Procurement Officer",
"description" => "Mid level"
],
[
"name" => "Auditor",
"description" => "Public Auditor"
],
[
    "name" => "Budget officer",
    "description" => "Accounting department"
],
[
    "name" => "Budget manager",
    "description" => "Approve budget commitment"
],
[
    "name" => "Senior Procurement Officer",
    "description" => "senior procurement officer"
],
[
    "name" => "CEO",
    "description" => "CEO of hospital"
],
[
    "name" => "Parish Manager",
    "description" => "High Level "
],
[
    "name" => "Director Procurement",
    "description" => "the procurement director"
],
[
    "name" => "Supervisor",
    "description" => "department supervisor"
]
 ]);
    }
}
