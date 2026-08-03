<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use App\Models\InstantOrder;
use App\Models\InstantOrderReservation;
use App\Models\Order;
use App\Models\OrderNotification;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'          => Order::count(),
            'open_orders'           => Order::where('status', 'Open')->count(),
            'delivered_orders'      => Order::where('status', 'Delivered')->count(),
            'total_customer_orders' => CustomerOrder::count(),
            'updated_customer_orders' => CustomerOrder::where('is_updated', true)->count(),
            'total_instant_products' => InstantOrder::count(),
            'instant_reservations'  => InstantOrderReservation::count(),
            'notifications_count'   => OrderNotification::count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $updatedOrders = CustomerOrder::where('is_updated', true)
            ->with('order')
            ->latest('updated_by_customer_at')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'updatedOrders'));
    }
}
