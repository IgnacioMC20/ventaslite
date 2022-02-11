<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Product::create([
           'name' => 'LARAVEL Y LIVEWIRE',
           'cost' => 200,
           'price' => 350,
           'barcode' =>  '75010065987',
           'stock' => 1000,
           'alerts' => 10,
           'category_id' => 1,
           'image' => 'curso.png'
        ]);
        Product::create([
           'name' => 'RUNNING NIKE',
           'cost' => 600,
           'price' => 1500,
           'barcode' =>  '75010065988',
           'stock' => 200,
           'alerts' => 10,
           'category_id' => 2,
           'image' => 'curso.png'
        ]);
        Product::create([
           'name' => 'IPHONE 13',
           'cost' => 500,
           'price' => 850,
           'barcode' =>  '75010065989',
           'stock' => 1800,
           'alerts' => 10,
           'category_id' => 3,
           'image' => 'curso.png'
        ]);
        Product::create([
           'name' => 'PC GAMER',
           'cost' => 750,
           'price' => 1350,
           'barcode' =>  '75010065984',
           'stock' => 80,
           'alerts' => 10,
           'category_id' => 4,
           'image' => 'curso.png'
        ]);
    }
}
