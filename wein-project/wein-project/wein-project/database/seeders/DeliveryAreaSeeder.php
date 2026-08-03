<?php

namespace Database\Seeders;

use App\Models\DeliveryArea;
use Illuminate\Database\Seeder;

class DeliveryAreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            ['city_name' => 'Riyadh',  'delivery_price' => 15.00],
            ['city_name' => 'Jeddah',  'delivery_price' => 20.00],
            ['city_name' => 'Dammam',  'delivery_price' => 25.00],
            ['city_name' => 'Mecca',   'delivery_price' => 20.00],
            ['city_name' => 'Medina',  'delivery_price' => 22.00],
        ];

        foreach ($areas as $area) {
            DeliveryArea::create($area);
        }
    }
}
