<?php

namespace App\Http\Controllers\Public;
use App\Models\CustomerOrder; // أو اسم الموديل الخاص بطلبية العميل
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\DeliveryArea;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerOrderController extends Controller
{
 public function store(Request $request, Order $order)
    {
        if (!$order->isOpen()) {
            return back()->withErrors(['order' => __('messages.order_closed')]);
        }

        $data = $request->validate([
            'customer_name'    => 'required|string|max:255',
            'phone_number'     => 'required|string|max:50',
            'password'         => 'required|string|min:4|confirmed',
            'cart_url'         => 'nullable|url',
            'notes'            => 'nullable|string',
            // تم إزالة حقل price من هنا حتى لا يتحكم به المستخدم
            'location'         => 'nullable|string|max:255',
            'delivery_area_id' => 'nullable|exists:delivery_areas,id',
        ]);

        $deliveryPrice = 0;
        if (!empty($data['delivery_area_id'])) {
            $area = DeliveryArea::find($data['delivery_area_id']);
            $deliveryPrice = $area ? (float) $area->delivery_price : 0;
        }

        $price      = 0.00; // السعر يبدأ بصفر لحين تحديثه من قبل الأدمن
        $tax        = (float) $order->tax;
        $subtotal   = $price + $deliveryPrice;
        $totalPrice = $subtotal + ($subtotal * $tax / 100);

        $phoneNumber = trim((string) $data['phone_number']);

        $customerOrder = CustomerOrder::create([
            'orders_id'      => $order->id,
            'customer_name'  => $data['customer_name'],
            'phone_number'   => $phoneNumber,
            'password_hash'  => Hash::make($data['password']),
            'cart_url'       => $data['cart_url'] ?? null,
            'notes'          => $data['notes'] ?? null,
            'price'          => $price,
            'delivery_price' => $deliveryPrice,
            'tax'            => $tax,
            'total_price'    => $totalPrice,
            'location'       => $data['location'] ?? null,
            'is_updated'     => false,
        ]);

        session(["co_auth_{$customerOrder->id}" => true]);

        return redirect()->route('orders.show', $order)->with('success', __('messages.order_placed'));
    }
public function getChatStatus($id)
{
    try {
        $customerOrder = CustomerOrder::with('order')->findOrFail($id);

        $userName    = $customerOrder->customer_name ?? 'عزيزنا العميل';
        $orderId     = $customerOrder->id;
        $orderTitle  = $customerOrder->order->title ?? '—';
        $orderStatus = $customerOrder->order->status ?? '—';

        // السعر والتفاصيل المالية
        $priceSet = (float) $customerOrder->price > 0;
        if ($priceSet) {
            $priceLines =
                "💵 سعر السلة: " . number_format($customerOrder->price, 2) . " ر.س\n" .
                "🚚 سعر التوصيل: " . number_format($customerOrder->delivery_price, 2) . " ر.س\n" .
                "🧾 الضريبة: " . number_format($customerOrder->tax, 2) . "%\n" .
                "💰 الإجمالي الكلي: " . number_format($customerOrder->total_price, 2) . " ر.س";
        } else {
            $priceLines = "⏳ سعر السلة لم يتم تحديده بعد من قبل الإدارة — سيتم إشعارك فور التحديث.";
        }

        // تاريخ الوصول المتوقع
        $arrivalText = ($customerOrder->order && $customerOrder->order->expected_arrival_date)
            ? Carbon::parse($customerOrder->order->expected_arrival_date)->format('d M Y')
            : 'لم يتحدد بعد';

        // الموقع
        $locationLine = $customerOrder->location
            ? "📍 موقع التسليم: {$customerOrder->location}"
            : "📍 موقع التسليم: غير محدد";

        // رابط السلة
        $cartLine = $customerOrder->cart_url
            ? "🛒 رابط السلة: مسجّل ✓"
            : "🛒 رابط السلة: لم يُضف بعد";

        // آخر تعديل من العميل
        $modifiedLine = $customerOrder->is_updated
            ? "✏️ آخر تعديل: " . $customerOrder->updated_by_customer_at?->format('d M Y H:i')
            : "✏️ لم تجرِ أي تعديلات على الطلب";

        $botMessage =
            "مرحباً {$userName}! 👋\n\n" .
            "━━━━━━━━━━━━━━━━━━\n" .
            "📋 تفاصيل طلبيتك رقم #{$orderId}\n" .
            "━━━━━━━━━━━━━━━━━━\n\n" .
            "📦 الطلب الرئيسي: {$orderTitle}\n" .
            "🔄 حالة الطلب: {$orderStatus}\n" .
            "📅 موعد الوصول المتوقع: {$arrivalText}\n\n" .
            "━━━ التفاصيل المالية ━━━\n" .
            "{$priceLines}\n\n" .
            "━━━ معلومات إضافية ━━━\n" .
            "{$locationLine}\n" .
            "{$cartLine}\n" .
            "{$modifiedLine}\n\n" .
            "نحن هنا دائماً لخدمتك! 🌟";

        return response()->json([
            'success' => true,
            'message' => $botMessage,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'عذراً، حدث خطأ في النظام أو أن الطلب غير موجود.',
        ], 500);
    }
}
   public function authenticate(Request $request, Order $order)
{
    $request->validate([
        'phone_number' => 'required|string',
        'password'     => 'required|string',
    ]);

    $phone = trim((string) $request->phone_number);

    // البحث عن العميل برقم الهاتف المرتبط حصرياً بهذا الطلب الرئيسي ($order->id)
    $customerOrder = CustomerOrder::where('orders_id', $order->id)
                                  ->where('phone_number', $phone)
                                  ->first();

    if (!$customerOrder) {
        return back()->withErrors([
            'auth' => 'رقم الهاتف هذا غير مسجل في هذا الطلب.'
        ])->withInput();
    }

    if (!Hash::check($request->password, $customerOrder->password_hash)) {
        return back()->withErrors([
            'auth' => 'كلمة المرور غير صحيحة.'
        ])->withInput();
    }

    // تسجيل الدخول بنجاح للطلب الفرعي الخاص بهذا العميل
    session(["co_auth_{$customerOrder->id}" => true]);

    return redirect()->route('customer-orders.show', $customerOrder->id);
}

    public function show(CustomerOrder $customerOrder)
    {
        if (!session("co_auth_{$customerOrder->id}")) {
            abort(403);
        }

        $customerOrder->load('order');

return view('public.orders.customer-order', compact('customerOrder'));    }

   public function update(Request $request, CustomerOrder $customerOrder)
    {
        if (!session("co_auth_{$customerOrder->id}")) {
            abort(403);
        }

        if (!$customerOrder->order->isOpen()) {
            return back()->withErrors(['order' => __('messages.order_closed')]);
        }

        $data = $request->validate([
            'cart_url'         => 'nullable|url',
            'notes'            => 'nullable|string',
            // تم إزالة حقل price من هنا أيضاً منعاً لتعديله من قبل المستخدم
            'location'         => 'nullable|string|max:255',
            'delivery_area_id' => 'nullable|exists:delivery_areas,id',
        ]);

        $deliveryPrice = $customerOrder->delivery_price;
        if (!empty($data['delivery_area_id'])) {
            $area = DeliveryArea::find($data['delivery_area_id']);
            $deliveryPrice = $area ? (float) $area->delivery_price : 0;
        }

        $price      = (float) $customerOrder->price; // الحفاظ على السعر الحالي الذي وضعه الأدمن
        $tax        = (float) $customerOrder->tax;
        $subtotal   = $price + $deliveryPrice;
        $totalPrice = $subtotal + ($subtotal * $tax / 100);

        $customerOrder->update([
            'cart_url'               => $data['cart_url'] ?? null,
            'notes'                  => $data['notes'] ?? null,
            'delivery_price'         => $deliveryPrice,
            'total_price'            => $totalPrice,
            'location'               => $data['location'] ?? null,
            'is_updated'             => true,
            'updated_by_customer_at' => now(),
        ]);

        return back()->with('success', __('messages.updated_successfully'));
    }
    public function destroy(CustomerOrder $customerOrder)
    {
        if (!session("co_auth_{$customerOrder->id}")) {
            abort(403);
        }

        if (!$customerOrder->order->isOpen()) {
            return back()->withErrors(['order' => __('messages.order_closed')]);
        }

        $orderId = $customerOrder->orders_id;
        $customerOrder->delete();

        return redirect()->route('orders.show', $orderId)->with('success', __('messages.deleted_successfully'));
    }
}