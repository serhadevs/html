<?php

use Illuminate\Database\Seeder;

class StockCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    DB::table('stock_categories')->insert([
    [
        "name" => "Drugs",
    ],
    [
        "name" => "Medical Supplies",
      
    ],
    [
        "name" => "Food & Drink",
      
    ],
    [
        "name" => "Medical Gases",
      
    ],
    [
        "name" => "Clothing  incl. uniform",
      
    ],
    [
        "name" => "Stationery & Office Supplies",
        
    ],
     [
        "name" => "Fuel, Motor Vehicles",
    ],
    [
        "name" => "Fuel, Oil, Lubricants ( Generators)",
      
    ],
    [
        "name" => "Motor Vehicle Spares",
      
    ],
    [
        "name" => "Tyres & Tubes",
      
    ],
    [
        "name" => "Repairs to Building",
      
    ],
    [
        "name" => "Printing & Photocopying Servicesr",
        
    ],
     [
        "name" => "Repairs, Furniture",
    ],
    [
        "name" => "Repairs to other Machinery & Equipment",
      
    ],
    [
        "name" => "Repairs & Service to Vehicles",
      
    ],
    [
        "name" => "Repairs, Computer Hardware",
      
    ],
    [
        "name" => "Software Maintenance",
      
    ],
    [
        "name" => "Printer Cartridges/Toners",
        
    ],
      [
        "name" => "Toilet Articles (Soap, Tissue, Towel, Disinf.)",
        
    ],
      [
        "name" => "Seminars & Workshop",
        
    ],
      [
        "name" => "Pest Control & Waste Disposal",
        
    ],
      [
        "name" => "Medical/Post Mortem & Burial Services",
        
    ],
      [
        "name" => "Security Contracted Services",
        
    ],
      [
        "name" => "Dietary Contracted Services",
        
    ],
      [
        "name" => "Portering & Cleaning Contracted Services",
        
    ],
      [
        "name" => "Laundry Contracted Services",
        
    ],
    [
        "name" => "Cooking Fuel",
        
    ],
    [
        "name" => "Other Goods & Services",
        
    ],
    [
        "name" => "Rental/Haulage & Transportation Services & Equipment",
        
    ],
    [
        "name" => "Purchase of Scientific Equipment",
        
    ],
    [
        "name" => "Purchase of Office Furniture & Equipment",
        
    ],
    [
        "name" => "Purchase of Machinery & Equipment",
        
    ],
     [
        "name" => "Purchase of Computer",
        
    ],
     [
        "name" => "Safety & Security equipment installation/services",
        
    ],
     [
        "name" => "Purchase of Motor Vehicle",
        
    ],
    [
        "name" => "Capital Projects",
        
    ],

    

    

]);

    }
}


