@extends('layouts.admin')
@section('title', 'Customer Order — ' . $customerOrder->customer_name)

@section('content')

<div class="co-show-wrap">

    {{-- ── HEADER ── --}}
    <div class="co-header">
        <div>
            <h1 class="co-title">{{ $customerOrder->customer_name }}</h1>
            <span class="co-sub">#{{ $customerOrder->id }}</span>
            @if($customerOrder->is_updated)
                <span class="co-badge updated">{{ __('messages.order_modified') }}</span>
            @endif
        </div>
        <a href="{{ route('admin.customer-orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
    </div>

    {{-- ── TOP GRID (info + pricing) ── --}}
    <div class="co-top-grid">

        {{-- Customer Info --}}
        <div class="co-card">
            <div class="co-card-head">👤 {{ __('messages.customer_name') }}</div>
            <div class="co-card-body">
                <div class="co-row"><span class="co-lbl">{{ __('messages.customer_name') }}</span><span class="co-val">{{ $customerOrder->customer_name }}</span></div>
                <div class="co-row"><span class="co-lbl">{{ __('messages.phone_number') }}</span><span class="co-val">{{ $customerOrder->phone_number }}</span></div>
                <div class="co-row"><span class="co-lbl">{{ __('messages.location') }}</span><span class="co-val">{{ $customerOrder->location ?? '—' }}</span></div>
                <div class="co-row">
                    <span class="co-lbl">{{ __('messages.order') }}</span>
                    <span class="co-val">
                        <a href="{{ route('admin.orders.show', $customerOrder->orders_id) }}" style="color:#60a5fa">
                            {{ $customerOrder->order->title ?? '—' }}
                        </a>
                    </span>
                </div>
                <div class="co-row"><span class="co-lbl">{{ __('messages.created_at') }}</span><span class="co-val">{{ $customerOrder->created_at->format('d M Y H:i') }}</span></div>
                @if($customerOrder->is_updated)
                    <div class="co-row">
                        <span class="co-lbl">Modified</span>
                        <span class="co-val">{{ $customerOrder->updated_by_customer_at?->format('d M Y H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Current Pricing (read-only) --}}
        <div class="co-card">
            <div class="co-card-head">💰 Pricing Summary</div>
            <div class="co-card-body">
                <div class="co-row">
                    <span class="co-lbl">{{ __('messages.price') }}</span>
                    <span class="co-val {{ $customerOrder->price > 0 ? 'price-set' : 'price-pending' }}">
                        @if($customerOrder->price > 0)
                            {{ number_format($customerOrder->price, 2) }} ر.س
                        @else
                            {{ __('messages.price_not_set') }}
                        @endif
                    </span>
                </div>
                <div class="co-row"><span class="co-lbl">{{ __('messages.delivery_price') }}</span><span class="co-val">{{ number_format($customerOrder->delivery_price, 2) }} ر.س</span></div>
                <div class="co-row"><span class="co-lbl">{{ __('messages.tax') }}</span><span class="co-val">{{ $customerOrder->tax }}%</span></div>
                <hr class="co-divider">
                <div class="co-row co-total-row">
                    <span class="co-lbl">{{ __('messages.total_price') }}</span>
                    <span class="co-val co-total-val">{{ number_format($customerOrder->total_price, 2) }} ر.س</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ── SET PRICE FORM ── --}}
    <div class="co-card co-price-form-card">
        <div class="co-card-head">✏️ {{ __('messages.set_customer_price') }}</div>
        <div class="co-card-body">
            @if(session('success'))
                <div class="alert alert-success mb-3">✓ {{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.customer-orders.update-price', $customerOrder->id) }}">
                @csrf
                @method('PATCH')
                <div class="price-form-row">
                    <div class="price-input-wrap">
                        <label class="price-label">{{ __('messages.price') }} (ر.س)</label>
                        <input
                            type="number"
                            name="price"
                            class="form-control price-input @error('price') is-invalid @enderror"
                            value="{{ old('price', number_format($customerOrder->price, 2, '.', '')) }}"
                            step="0.01"
                            min="0"
                            placeholder="0.00"
                            required
                        >
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="price-preview">
                        <div class="preview-row">
                            <span>{{ __('messages.delivery_price') }}</span>
                            <span>{{ number_format($customerOrder->delivery_price, 2) }} ر.س</span>
                        </div>
                        <div class="preview-row">
                            <span>{{ __('messages.tax') }}</span>
                            <span>{{ $customerOrder->tax }}%</span>
                        </div>
                        <div class="preview-row preview-total">
                            <span>{{ __('messages.total_price') }}</span>
                            <span id="calc-total">—</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary price-submit-btn">
                        💾 {{ __('messages.set_price') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── ORDER DETAILS (cart url + notes) ── --}}
    @if($customerOrder->cart_url || $customerOrder->notes)
    <div class="co-card">
        <div class="co-card-head">📋 Order Details</div>
        <div class="co-card-body">
            @if($customerOrder->cart_url)
                <div class="co-row">
                    <span class="co-lbl">{{ __('messages.cart_url') }}</span>
                    <span class="co-val"><a href="{{ $customerOrder->cart_url }}" target="_blank" style="color:#60a5fa;word-break:break-all">{{ $customerOrder->cart_url }}</a></span>
                </div>
            @endif
            @if($customerOrder->notes)
                <div class="co-row" style="flex-direction:column;gap:.4rem">
                    <span class="co-lbl">{{ __('messages.notes') }}</span>
                    <p style="color:var(--text-secondary);margin:0">{{ $customerOrder->notes }}</p>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>

@endsection

@push('styles')
<style>
.co-show-wrap{display:flex;flex-direction:column;gap:1.5rem}

.co-header{
    display:flex;justify-content:space-between;align-items:flex-start;
    flex-wrap:wrap;gap:1rem;
    background:linear-gradient(135deg,#161b22,#1c2128);
    border:1px solid #30363d;border-radius:20px;padding:1.5rem 2rem;
}
.co-title{color:#fff;font-size:1.6rem;font-weight:800;margin:0}
.co-sub{color:#8b949e;font-size:.9rem;display:block;margin-top:.2rem}
.co-badge{display:inline-block;padding:.3rem .8rem;border-radius:999px;font-size:.75rem;font-weight:700;margin-inline-start:.5rem}
.co-badge.updated{background:rgba(234,179,8,.15);color:#facc15}

.co-top-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem}

.co-card{background:linear-gradient(180deg,#161b22,#11161c);border:1px solid #30363d;border-radius:20px;overflow:hidden}
.co-card-head{background:#0d1117;border-bottom:1px solid #30363d;padding:1rem 1.5rem;color:#c9d1d9;font-weight:700;font-size:.95rem}
.co-card-body{padding:1.25rem 1.5rem;display:flex;flex-direction:column;gap:.75rem}

.co-row{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem}
.co-lbl{color:#8b949e;font-size:.85rem}
.co-val{color:#e6edf3;font-weight:600;font-size:.9rem;text-align:end}

.co-divider{border-color:#30363d;margin:.25rem 0}
.co-total-row{margin-top:.25rem}
.co-total-val{color:#34d399;font-size:1.1rem;font-weight:800}
.price-set{color:#34d399}
.price-pending{color:#f59e0b;font-style:italic}

/* Price form */
.co-price-form-card{}
.price-form-row{display:flex;gap:1.25rem;align-items:flex-end;flex-wrap:wrap}
.price-input-wrap{flex:0 0 180px}
.price-label{display:block;color:#8b949e;font-size:.85rem;margin-bottom:.5rem;font-weight:600}
.price-input{font-size:1.1rem;font-weight:700;text-align:center}
.price-preview{flex:1;background:#0d1117;border:1px solid #30363d;border-radius:14px;padding:1rem;min-width:200px}
.preview-row{display:flex;justify-content:space-between;color:#8b949e;font-size:.85rem;padding:.25rem 0}
.preview-total{color:#e6edf3;font-weight:700;border-top:1px solid #30363d;margin-top:.5rem;padding-top:.5rem}
.price-submit-btn{white-space:nowrap;padding:.75rem 1.5rem}

@media(max-width:768px){
    .co-top-grid{grid-template-columns:1fr}
    .co-header{flex-direction:column}
    .price-form-row{flex-direction:column}
    .price-input-wrap{flex:none;width:100%}
    .price-preview{width:100%}
    .price-submit-btn{width:100%}
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.querySelector('input[name="price"]');
    const calcTotal  = document.getElementById('calc-total');
    const delivery   = {{ (float)$customerOrder->delivery_price }};
    const tax        = {{ (float)$customerOrder->tax }};

    function recalc() {
        const price    = parseFloat(priceInput.value) || 0;
        const subtotal = price + delivery;
        const total    = subtotal + (subtotal * tax / 100);
        calcTotal.textContent = total.toFixed(2) + ' ر.س';
    }

    priceInput.addEventListener('input', recalc);
    recalc();
});
</script>
@endpush
