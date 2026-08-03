<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerOrder::query()->with('order');

        // فلترة آمنة وحماية من مطابقة النصوص مع الأرقام
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                // البحث بالـ ID فقط إذا كان المدخل رقماً
                if (is_numeric($search)) {
                    $q->orWhere('id', $search);
                }

                // البحث في باقي الحقول النصية بأمان
                $q->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $customerOrders = $query->latest()->paginate(20);

        return view('admin.customer-orders.index', compact('customerOrders'));
    }

    public function show($id)
    {
        // حماية من البحث بنص بدلاً من رقم في الـ URL
        if (!is_numeric($id)) {
            abort(404);
        }

        $customerOrder = CustomerOrder::with('order')->findOrFail($id);

        return view('admin.customer-orders.show', compact('customerOrder'));
    }

    public function destroy($id)
    {
        if (!is_numeric($id)) {
            abort(404);
        }

        $customerOrder = CustomerOrder::findOrFail($id);
        $customerOrder->delete();

        return back()->with('success', __('messages.deleted_successfully'));
    }
}