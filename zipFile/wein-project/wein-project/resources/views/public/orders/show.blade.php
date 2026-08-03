@extends('layouts.public')
@section('title', $order->title)

@section('content')
{{-- Header --}}
<div class="page-header">
    <div>
        <h1>{{ $order->title }}</h1>
        <span class="badge badge-{{ strtolower($order->status) }}">{{ __('messages.' . $order->status) }}</span>
    </div>
    <a href="{{ route('home') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

{{-- Order Info --}}
<div class="card mb-3">
    <div class="card-body">
        @if($order->description)
            <p style="color:var(--text-secondary);margin-bottom:.75rem">{{ $order->description }}</p>
        @endif
        <div style="font-size:.85rem;color:var(--text-muted);display:flex;gap:1.5rem;flex-wrap:wrap">
            @if($order->expected_arrival_date)
                <span>📅 {{ __('messages.expected_arrival') }}: {{ $order->expected_arrival_date->format('d M Y') }}</span>
            @endif
            <span>🧾 {{ __('messages.tax') }}: {{ $order->tax }}%</span>
        </div>
    </div>
</div>

{{-- Notifications --}}
@if($notifications->count())
<div class="mb-3">
    <h3 style="margin-bottom:.75rem;font-size:1rem">🔔 {{ __('messages.notifications') }}</h3>
    @foreach($notifications as $n)
        <div class="notification-item">
            <strong>{{ $n->title }}</strong>
            <p style="margin-top:.2rem;font-size:.9rem">{{ $n->message }}</p>
        </div>
    @endforeach
</div>
@endif

{{-- Actions --}}
<div class="d-flex gap-1 mb-3" style="flex-wrap:wrap">
    @if($order->isOpen())
        <button class="btn btn-primary" onclick="openModal('add-order-modal')">
            + {{ __('messages.add_customer_order') }}
        </button>
    @endif
    <button class="btn btn-secondary" onclick="openModal('access-order-modal')">
        🔑 {{ __('messages.view_my_order') }}
    </button>
</div>

{{-- ── Add Customer Order Modal ── --}}
<div class="modal-overlay" id="add-order-modal">
    <div class="modal">
        <div class="modal-header">
            <span>{{ __('messages.add_customer_order') }}</span>
            <button class="modal-close" onclick="closeModal('add-order-modal')">✕</button>
        </div>
        <form method="POST" action="{{ route('customer-orders.store', $order->id) }}">
            @csrf
            <div class="modal-body">
                {{-- عرض أخطاء الإدخال إن وجدت --}}
                @if($errors->any() && !$errors->has('auth'))
                    <div class="alert alert-danger mb-3" style="font-size:.85rem;">
                        <ul style="margin:0; padding-inline-start: 1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.customer_name') }} *</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.phone_number') }} *</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.cart_url') }}</label>
                    <input type="url" name="cart_url" class="form-control" value="{{ old('cart_url') }}" placeholder="https://...">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.price') }} *</label>
                        <input type="number" id="price_input" name="price" class="form-control" value="{{ old('price', 0) }}" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.select_city') }}</label>
                        <select id="delivery_area_id" name="delivery_area_id" class="form-control">
                            <option value="" data-price="0">— {{ __('messages.select_city') }} —</option>
                            @foreach($deliveryAreas as $area)
                                <option value="{{ $area->id }}" data-price="{{ $area->delivery_price }}" {{ old('delivery_area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->city_name }} ({{ number_format($area->delivery_price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex align-center gap-1 mb-2" style="font-size:.85rem;color:var(--text-muted)">
                    <span>{{ __('messages.delivery_price') }}: <strong id="delivery-price-display">0.00</strong></span>
                    <span style="margin-inline-start:1rem">{{ __('messages.total_price') }}: <strong id="total-display">0.00</strong></span>
                    <input type="hidden" id="tax_pct" value="{{ $order->tax }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.location') }}</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.notes') }}</label>
                    <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.password') }} *</label>
                        <input type="password" name="password" class="form-control" required minlength="4" placeholder="Min 4 chars">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.password_confirm') }} *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="alert alert-info" style="font-size:.85rem;margin-top:.5rem">
                    💡 Save your phone and password — you'll need them to access your order later.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('add-order-modal')">{{ __('messages.cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Access My Order Modal ── --}}
<div class="modal-overlay" id="access-order-modal">
    <div class="modal" style="max-width:440px">
        <div class="modal-header">
            <span>{{ __('messages.my_order_access') }}</span>
            <button class="modal-close" onclick="closeModal('access-order-modal')">✕</button>
        </div>
        
        <form method="POST" action="{{ route('customer-orders.authenticate', $order->id) }}">
            @csrf
            
            <div class="modal-body">
                {{-- عرض خطأ الدخول المخصص --}}
                @if($errors->has('auth'))
                    <div class="alert alert-danger mb-3" style="font-size:.85rem; padding:.6rem .8rem;">
                        ⚠️ {{ $errors->first('auth') }}
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label">{{ __('messages.phone_number') }} *</label>
                    <input type="text" name="phone_number" class="form-control" required placeholder="07xxxxxxxx" value="{{ old('phone_number') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('messages.password') }} *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('access-order-modal')">{{ __('messages.cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript التحكم بالمودالات والحسابات --}}
<script>
  
    document.addEventListener('DOMContentLoaded', function() {
        // 1. التكفل بفتح المودال المناسب عند وجود أخطاء بعد الـ Refresh
        @if($errors->has('auth') || $errors->has('order'))
            openModal('access-order-modal');
        @elseif($errors->any())
            openModal('add-order-modal');
        @endif

        // 2. احتساب الإجمالي والتوصيل أثناء إدخال الطلب الجديد
        const priceInput = document.getElementById('price_input');
        const citySelect = document.getElementById('delivery_area_id');
        const deliveryDisplay = document.getElementById('delivery-price-display');
        const totalDisplay = document.getElementById('total-display');
        const taxPct = parseFloat(document.getElementById('tax_pct')?.value || 0);

        function calculateTotals() {
            if (!priceInput || !citySelect) return;

            const price = parseFloat(priceInput.value) || 0;
            const selectedOption = citySelect.options[citySelect.selectedIndex];
            const deliveryPrice = parseFloat(selectedOption?.getAttribute('data-price') || 0);

            const subtotal = price + deliveryPrice;
            const total = subtotal + (subtotal * taxPct / 100);

            deliveryDisplay.textContent = deliveryPrice.toFixed(2);
            totalDisplay.textContent = total.toFixed(2);
        }

        if (priceInput && citySelect) {
            priceInput.addEventListener('input', calculateTotals);
            citySelect.addEventListener('change', calculateTotals);
            calculateTotals(); // تشغيل أولي للحسابات
        }
    });
</script>
@endsection