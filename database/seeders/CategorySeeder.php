<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Category::create([
            'name' => 'Cursos',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Tennis',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Celulares',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'Computadoras',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);

    }
}
