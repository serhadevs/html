<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
         {
        
        // factory(App\User::class, 100)->create()->each(function ($user) {
        //     $user->posts()->save(factory(App\Post::class)->make());
        // });

        // factory(App\Supplier::class, 5000)->create()->each(function ($user) {
        //     $user->posts()->save(factory(App\Post::class)->make());
        // });

        // $this->call(UserTableSeeder::class);
        // $this->call(UnitTableSeeder::class);
        // $this->call(InstitutionTableSeeder::class);
        // $this->call(ParishTableSeeder::class);
        // $this->call(RoleTableSeeder::class);
        // $this->call(StockCategoryTableSeeder::class);
        // $this->call(UnitOfMeasurementTableSeeder::class);
        // $this->call(DepartmentTableSeeder::class);
        // $this->call(RequisitionTypeTableSeeder::class);
        // $this->call(SupplierTableSeeder::class); 
        // $this->call(ProcurementMethodTableSeeder::class);
        // $this->call(CurrencyTableSeeder::class);
        $this->call(AdvertisementMethodSeeder::class);


      
        // factory(App\Requisition::class, 100000)->create()->each(function ($user) {
        //     $user->posts()->save(factory(App\Post::class)->make());
        //     });
        

//             factory(App\User::class, 1000000)->create()->each(function ($user) {
//     $user->posts()->save(factory(App\Post::class)->make());
// });

   
        




        
    }
}
