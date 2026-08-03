<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('customerOrders')
            ->latest()
            ->get();

        return view('public.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $deliveryAreas  = DeliveryArea::orderBy('city_name')->get();
        $notifications  = $order->notifications()->latest()->get();

        return view('public.orders.show', compact('order', 'deliveryAreas', 'notifications'));
    }
}
