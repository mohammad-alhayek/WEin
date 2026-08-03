<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('customerOrders')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        return view('admin.orders.create', ['statuses' => Order::STATUSES]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'nullable|string',
            'expected_arrival_date' => 'nullable|date',
            'status'                => 'required|in:' . implode(',', Order::STATUSES),
            'tax'                   => 'nullable|numeric|min:0',
        ]);

        Order::create($data);

        return redirect()->route('admin.orders.index')->with('success', __('messages.created_successfully'));
    }

    public function show(Order $order)
    {
        $customerOrders = $order->customerOrders()->latest()->get();
        $notifications  = $order->notifications()->latest()->get();
        return view('admin.orders.show', compact('order', 'customerOrders', 'notifications'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', ['order' => $order, 'statuses' => Order::STATUSES]);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'nullable|string',
            'expected_arrival_date' => 'nullable|date',
            'status'                => 'required|in:' . implode(',', Order::STATUSES),
            'tax'                   => 'nullable|numeric|min:0',
        ]);

        $order->update($data);

        return redirect()->route('admin.orders.show', $order)->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', __('messages.deleted_successfully'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Order::STATUSES),
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', __('messages.updated_successfully'));
    }
}
