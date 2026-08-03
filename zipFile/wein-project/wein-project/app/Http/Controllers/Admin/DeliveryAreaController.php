<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class DeliveryAreaController extends Controller
{
    public function index()
    {
        $areas = DeliveryArea::orderBy('city_name')->get();
        return view('admin.delivery-areas.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.delivery-areas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'city_name'      => 'required|string|max:255',
            'delivery_price' => 'required|numeric|min:0',
        ]);

        DeliveryArea::create($data);

        return redirect()->route('admin.delivery-areas.index')->with('success', __('messages.created_successfully'));
    }

    public function edit(DeliveryArea $deliveryArea)
    {
        return view('admin.delivery-areas.edit', compact('deliveryArea'));
    }

    public function update(Request $request, DeliveryArea $deliveryArea)
    {
        $data = $request->validate([
            'city_name'      => 'required|string|max:255',
            'delivery_price' => 'required|numeric|min:0',
        ]);

        $deliveryArea->update($data);

        return redirect()->route('admin.delivery-areas.index')->with('success', __('messages.updated_successfully'));
    }

    public function destroy(DeliveryArea $deliveryArea)
    {
        $deliveryArea->delete();
        return back()->with('success', __('messages.deleted_successfully'));
    }

    // JSON endpoint for public delivery price lookup
    public function publicIndex()
    {
        return response()->json(DeliveryArea::select('id', 'city_name', 'delivery_price')->orderBy('city_name')->get());
    }
}
