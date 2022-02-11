<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denomitaion;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Denomitaion::create([
            'type' => 'BILLETE',
            'value' => 1000
        ]);
        Denomitaion::create([
            'type' => 'BILLETE',
            'value' => 500
        ]);
        Denomitaion::create([
            'type' => 'BILLETE',
            'value' => 200
        ]);
        Denomitaion::create([
            'type' => 'BILLETE',
            'value' => 100
        ]);
        Denomitaion::create([
            'type' => 'BILLETE',
            'value' => 50
        ]);
        Denomitaion::create([
            'type' => 'BILLETE',
            'value' => 20
        ]);
        Denomitaion::create([
            'type' => 'MONEDA',
            'value' => 10
        ]);
        Denomitaion::create([
            'type' => 'MONEDA',
            'value' => 5
        ]);
        Denomitaion::create([
            'type' => 'MONEDA',
            'value' => 2
        ]);
        Denomitaion::create([
            'type' => 'MONEDA',
            'value' => 1
        ]);
        Denomitaion::create([
            'type' => 'MONEDA',
            'value' => 0.5
        ]);
        Denomitaion::create([
            'type' => 'OTRO',
            'value' => 0
        ]);
    }
}
