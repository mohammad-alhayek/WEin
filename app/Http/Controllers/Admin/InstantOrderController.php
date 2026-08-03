<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstantOrder;
use App\Models\InstantOrderReservation;
use Illuminate\Http\Request;

class InstantOrderController extends Controller
{
    public function index()
    {
        $products = InstantOrder::withCount('reservations')->latest()->get();
        return view('admin.instant-orders.index', compact('products'));
    }

    public function create()
    {
        return view('admin.instant-orders.create', ['statuses' => InstantOrder::STATUSES]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'product_url'    => 'nullable|url',
            'image_url'      => 'nullable|url',
            'price'          => 'required|numeric|min:0',
            'delivery_price' => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'specifications' => 'nullable|string',
            'status'         => 'required|in:' . implode(',', InstantOrder::STATUSES),
        ]);

        InstantOrder::create($data);

        return redirect()->route('admin.instant-orders.index')->with('success', __('messages.created_successfully'));
    }

    public function show(InstantOrder $instantOrder)
    {
        $instantOrder->load('reservations');
        return view('admin.instant-orders.show', compact('instantOrder'));
    }

    public function edit(InstantOrder $instantOrder)
    {
        return view('admin.instant-orders.edit', ['product' => $instantOrder, 'statuses' => InstantOrder::STATUSES]);
    }

    public function update(Request $request, InstantOrder $instantOrder)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'product_url'    => 'nullable|url',
            'image_url'      => 'nullable|url',
            'price'          => 'required|numeric|min:0',
            'delivery_price' => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'specifications' => 'nullable|string',
            'status'         => 'required|in:' . implode(',', InstantOrder::STATUSES),
        ]);

        $instantOrder->update($data);

        return redirect()->route('admin.instant-orders.index')->with('success', __('messages.updated_successfully'));
    }

    public function destroy(InstantOrder $instantOrder)
    {
        $instantOrder->delete();
        return redirect()->route('admin.instant-orders.index')->with('success', __('messages.deleted_successfully'));
    }

    public function reservations(InstantOrder $instantOrder)
    {
        $reservations = $instantOrder->reservations()->latest()->get();
        return view('admin.instant-orders.reservations', compact('instantOrder', 'reservations'));
    }

    public function destroyReservation(InstantOrderReservation $reservation)
    {
        $instantOrder = $reservation->instantOrder;
        // Restore quantity
        $instantOrder->increment('quantity', $reservation->quantity);
        if ($instantOrder->status === 'SoldOut' && $instantOrder->quantity > 0) {
            $instantOrder->update(['status' => 'Available']);
        }
        $reservation->delete();
        return back()->with('success', __('messages.deleted_successfully'));
    }
}
