@extends('layouts.public')
@section('title', __('messages.instant_orders'))

@section('content')
<div class="page-header">
    <h1>⚡ {{ __('messages.instant_orders') }}</h1>
    <div class="view-toggle">
        <button data-view="card" class="active" title="Card View">⊞</button>
        <button data-view="list" title="List View">☰</button>
    </div>
</div>

@if($products->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
        <p>{{ __('messages.no_data') }}</p>
    </div>
@else
    <div id="products-container" class="products-grid">
        @foreach($products as $product)
        <div class="product-card">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" loading="lazy">
            @else
                <div style="height:180px;background:var(--bg-primary);display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--text-muted)">📦</div>
            @endif
            <div class="product-body">
                <div class="product-title">{{ $product->title }}</div>
                @if($product->description)
                    <p style="font-size:.85rem;color:var(--text-muted);margin:.4rem 0">{{ Str::limit($product->description, 80) }}</p>
                @endif
                <div class="d-flex align-center" style="justify-content:space-between;margin-top:.75rem;flex-wrap:wrap;gap:.5rem">
                    <div>
                        <div class="product-price">{{ number_format($product->price, 2) }}</div>
                        <small class="text-muted">+{{ number_format($product->delivery_price, 2) }} delivery · {{ $product->quantity }} left</small>
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="openReserveModal({{ $product->id }}, '{{ addslashes($product->title) }}', {{ $product->quantity }})">
                        {{ __('messages.reserve') }}
                    </button>
                </div>
                @if($product->product_url)
                    <a href="{{ $product->product_url }}" target="_blank" class="btn btn-secondary btn-sm" style="margin-top:.5rem;width:100%">View Product ↗</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Reserve Modal --}}
<div class="modal-overlay" id="reserve-modal">
    <div class="modal" style="max-width:500px">
        <div class="modal-header">
            <span>{{ __('messages.reserve') }}: <span id="modal-product-title"></span></span>
            <button class="modal-close" onclick="closeModal('reserve-modal')">✕</button>
        </div>
        <form method="POST" id="reserve-form" action="">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.customer_name') }} *</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.phone_number') }} *</label>
                        <input type="text" name="phone_number" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.quantity') }} *</label>
                        <input type="number" name="quantity" id="reserve-qty" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.location') }}</label>
                        <input type="text" name="location" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.notes') }}</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
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
                <div class="alert alert-info" style="font-size:.85rem">
                    💡 Save your phone and password — you'll need them to manage your reservation.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('reserve-modal')">{{ __('messages.cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
</div>

{{-- Access Reservation Modal --}}
<div style="margin-top:2rem;text-align:center">
    <button class="btn btn-secondary" onclick="openModal('access-reservation-modal')">
        🔑 {{ __('messages.view_my_order') }}
    </button>
</div>

<div class="modal-overlay" id="access-reservation-modal">
    <div class="modal" style="max-width:440px">
        <div class="modal-header">
            <span>{{ __('messages.my_order_access') }}</span>
            <button class="modal-close" onclick="closeModal('access-reservation-modal')">✕</button>
        </div>
        <form method="POST" action="{{ route('reservations.authenticate') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.phone_number') }}</label>
                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required placeholder="أدخل رقم هاتفك">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" name="password" class="form-control" required placeholder="كلمة المرور">
                </div>
                @error('auth')
                    <div class="alert alert-danger" style="font-size:.85rem; margin-top:.5rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('access-reservation-modal')">{{ __('messages.cancel') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openReserveModal(productId, productTitle, maxQty) {
    document.getElementById('modal-product-title').textContent = productTitle;
    document.getElementById('reserve-form').action = '/instant-orders/' + productId + '/reserve';
    const qtyInput = document.getElementById('reserve-qty');
    qtyInput.max = maxQty;
    qtyInput.value = 1;
    openModal('reserve-modal');
}
</script>
@endsection