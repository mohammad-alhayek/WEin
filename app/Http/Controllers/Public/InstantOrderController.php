<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\InstantOrder;
use App\Models\InstantOrderReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstantOrderController extends Controller
{
    public function index()
    {
        $products = InstantOrder::where('status', 'Available')
            ->where('quantity', '>', 0)
            ->latest()
            ->get();

        return view('public.instant-orders.index', compact('products'));
    }

    public function reserve(Request $request, InstantOrder $instantOrder)
    {
        if (!$instantOrder->isAvailable()) {
            return back()->withErrors(['product' => __('messages.product_unavailable')]);
        }

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number'  => 'required|string|max:50',
            'location'      => 'nullable|string|max:255',
            'quantity'      => 'required|integer|min:1|max:' . $instantOrder->quantity,
            'notes'         => 'nullable|string',
            'password'      => 'required|string|min:4|confirmed',
        ]);

        $reservation = InstantOrderReservation::create([
            'instant_order_id' => $instantOrder->id,
            'customer_name'    => $data['customer_name'],
            'phone_number'     => $data['phone_number'],
            'location'         => $data['location'] ?? null,
            'quantity'         => $data['quantity'],
            'notes'            => $data['notes'] ?? null,
            'password_hash'    => Hash::make($data['password']),
        ]);

        // Reduce quantity
        $instantOrder->decrement('quantity', $data['quantity']);
        $instantOrder->refresh();

        if ($instantOrder->quantity <= 0) {
            $instantOrder->update(['status' => 'SoldOut']);
        }

        session(["res_auth_{$reservation->id}" => true]);

        return redirect()->route('instant-orders.index')->with('success', __('messages.reservation_placed'));
    }

   public function authenticate(Request $request)
{
    $data = $request->validate([
        'phone_number' => 'required|string',
        'password'     => 'required|string',
    ]);

    $phone = trim((string) $data['phone_number']);

    // البحث عن الحجز باستخدام رقم الهاتف فقط
    $res = InstantOrderReservation::where('phone_number', $phone)->first();

    if (!$res || !$res->verifyPassword($data['password'])) {
        return back()->withErrors([
            'auth' => __('messages.invalid_credentials') // أو رسالة مخصصة مثل: "رقم الهاتف أو كلمة المرور غير صحيحة."
        ])->withInput();
    }

    // تسجيل الدخول بنجاح للجلسة الخاصة بهذا الحجز
    session(["res_auth_{$res->id}" => true]);

    // إعادة التوجيه لصفحة تفاصيل الحجز الخاصة به مباشرة
    return redirect()->route('reservations.show', $res->id)
        ->with('success', __('messages.authenticated'));
}

    public function showReservation(InstantOrderReservation $reservation)
    {
        if (!session("res_auth_{$reservation->id}")) {
            return redirect()->route('instant-orders.index')
                ->withErrors(['auth' => __('messages.auth_required')]);
        }
        $reservation->load('instantOrder');
        return view('public.instant-orders.reservation', compact('reservation'));
    }

    public function updateReservation(Request $request, InstantOrderReservation $reservation)
    {
        if (!session("res_auth_{$reservation->id}")) {
            abort(403);
        }

        $data = $request->validate([
            'location' => 'nullable|string|max:255',
            'notes'    => 'nullable|string',
        ]);

        $reservation->update($data);

        return back()->with('success', __('messages.updated_successfully'));
    }

    public function destroyReservation(InstantOrderReservation $reservation)
    {
        if (!session("res_auth_{$reservation->id}")) {
            abort(403);
        }

        $instantOrder = $reservation->instantOrder;
        $instantOrder->increment('quantity', $reservation->quantity);
        if ($instantOrder->status === 'SoldOut' && $instantOrder->quantity > 0) {
            $instantOrder->update(['status' => 'Available']);
        }

        $reservation->delete();

        return redirect()->route('instant-orders.index')->with('success', __('messages.deleted_successfully'));
    }
}
