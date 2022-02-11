<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        User::create([
            'name' => 'Juan Ignacio',
            'phone' => '12345678',
            'email' => 'ign@gmail.com',
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
        User::create([
            'name' => 'Melissa Albahat',
            'phone' => '87654321',
            'email' => 'melissa@gmail.com',
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);
    }
}
