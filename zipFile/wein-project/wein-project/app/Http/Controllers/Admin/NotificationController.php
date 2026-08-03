<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = OrderNotification::with('order')->latest()->paginate(20);
        $orders = Order::orderBy('title')->get();
        return view('admin.notifications.index', compact('notifications', 'orders'));
    }

    public function create()
    {
        $orders = Order::orderBy('title')->get();
        return view('admin.notifications.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'title'    => 'required|string|max:255',
            'message'  => 'required|string',
        ]);

        OrderNotification::create($data);

        return redirect()->route('admin.notifications.index')->with('success', __('messages.created_successfully'));
    }

    public function edit(OrderNotification $notification)
    {
        $orders = Order::orderBy('title')->get();
        return view('admin.notifications.edit', compact('notification', 'orders'));
    }

    public function update(Request $request, OrderNotification $notification)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'title'    => 'required|string|max:255',
            'message'  => 'required|string',
        ]);

        $notification->update($data);

        return redirect()->route('admin.notifications.index')->with('success', __('messages.updated_successfully'));
    }

    public function destroy(OrderNotification $notification)
    {
        $notification->delete();
        return back()->with('success', __('messages.deleted_successfully'));
    }
}
