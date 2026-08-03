<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\InstantOrder;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::create([
            'title'                 => 'SHEIN Summer 2024 Batch',
            'description'           => 'Summer clothing and accessories batch order.',
            'expected_arrival_date' => now()->addDays(30),
            'status'                => 'Open',
            'tax'                   => 15,
        ]);

        OrderNotification::create([
            'order_id' => $order->id,
            'title'    => 'Order Opened',
            'message'  => 'The order is now open. You can add your items.',
        ]);

        Order::create([
            'title'                 => 'SHEIN Spring 2024 Batch',
            'description'           => 'Spring collection - closed.',
            'expected_arrival_date' => now()->subDays(10),
            'status'                => 'Delivered',
            'tax'                   => 15,
        ]);

        InstantOrder::create([
            'title'          => 'Sample Instant Product',
            'description'    => 'A sample product available for immediate reservation.',
            'price'          => 99.00,
            'delivery_price' => 15.00,
            'quantity'       => 10,
            'status'         => 'Available',
        ]);
    }
}
