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

                {{-- City select only — price set by admin after submission --}}
                <div class="form-group">
                    <label class="form-label">{{ __('messages.select_city') }}</label>
                    <select id="delivery_area_id" name="delivery_area_id" class="form-control">
                        <option value="" data-price="0">— {{ __('messages.select_city') }} —</option>
                        @foreach($deliveryAreas as $area)
                            <option value="{{ $area->id }}" data-price="{{ $area->delivery_price }}"
                                {{ old('delivery_area_id') == $area->id ? 'selected' : '' }}>
                                {{ $area->city_name }} ({{ number_format($area->delivery_price, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="font-size:.82rem;color:var(--text-muted);margin-bottom:.75rem;display:flex;gap:1rem;flex-wrap:wrap">
                    <span>{{ __('messages.delivery_price') }}: <strong id="delivery-price-display">0.00</strong></span>
                    <input type="hidden" id="tax_pct" value="{{ $order->tax }}">
                </div>
                <div class="alert alert-info" style="font-size:.82rem;margin-bottom:.75rem">
                    💡 سعر السلة سيتم تحديده من قِبل الإدارة بعد إضافة طلبك.
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->has('auth') || $errors->has('order'))
            openModal('access-order-modal');
        @elseif($errors->any())
            openModal('add-order-modal');
        @endif

        // احتساب سعر التوصيل عند اختيار المدينة
        const citySelect      = document.getElementById('delivery_area_id');
        const deliveryDisplay = document.getElementById('delivery-price-display');

        function updateDelivery() {
            if (!citySelect || !deliveryDisplay) return;
            const opt = citySelect.options[citySelect.selectedIndex];
            const dp  = parseFloat(opt?.getAttribute('data-price') || 0);
            deliveryDisplay.textContent = dp.toFixed(2);
        }

        if (citySelect) {
            citySelect.addEventListener('change', updateDelivery);
            updateDelivery();
        }
    });
</script>
@endsection
