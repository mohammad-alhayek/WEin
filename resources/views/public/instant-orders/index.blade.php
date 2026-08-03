@extends('layouts.public')
@section('title', __('messages.instant_orders'))

@section('content')

<div class="pub-idx-header">
    <h1 style="margin:0;font-size:1.6rem;font-weight:800">⚡ {{ __('messages.instant_orders') }}</h1>
    <div class="view-toggle">
        <button data-view="card" class="active" title="Card View">⊞</button>
        <button data-view="list" title="List View">☰</button>
    </div>
</div>

{{-- Search + Status filter --}}
<div class="pub-filter-bar">
    <div class="pub-search-wrap">
        <span class="pub-filter-icon">🔍</span>
        <input type="text" id="searchInput" class="pub-filter-input" placeholder="{{ __('messages.search') }}...">
    </div>
    <select id="statusFilter" class="pub-filter-select">
        <option value="">{{ __('messages.all_statuses') }}</option>
        <option value="Available">{{ __('messages.Available') }}</option>
        <option value="SoldOut">{{ __('messages.SoldOut') }}</option>
    </select>
</div>

@if($products->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
        <p>{{ __('messages.no_data') }}</p>
    </div>
@else
    <div id="products-container" class="products-grid">
        @foreach($products as $product)
        <div class="product-card io-filterable"
             data-status="{{ $product->status }}"
             data-title="{{ strtolower($product->title) }} {{ strtolower($product->description ?? '') }}">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->title }}" loading="lazy">
            @else
                <div style="height:180px;background:var(--bg-primary);display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--text-muted)">📦</div>
            @endif
            <div class="product-body">
                <div class="product-title">{{ $product->title }}</div>
                <span class="badge badge-{{ strtolower($product->status) }}" style="margin:.25rem 0 .5rem">
                    {{ __('messages.' . $product->status) }}
                </span>
                @if($product->description)
                    <p style="font-size:.85rem;color:var(--text-muted);margin:.4rem 0">{{ Str::limit($product->description, 80) }}</p>
                @endif
                <div class="d-flex align-center" style="justify-content:space-between;margin-top:.75rem;flex-wrap:wrap;gap:.5rem">
                    <div>
                        <div class="product-price">{{ number_format($product->price, 2) }}</div>
                        <small class="text-muted">+{{ number_format($product->delivery_price, 2) }} delivery · {{ $product->quantity }} left</small>
                    </div>
                    <button
                        class="btn btn-primary btn-sm"
                        onclick="openReserveModal({{ $product->id }}, '{{ addslashes($product->title) }}', {{ $product->quantity }})"
                        {{ $product->status !== 'Available' ? 'disabled' : '' }}>
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
    <div id="noResults" style="display:none" class="empty-state">
        <p>{{ __('messages.no_orders_found') }}</p>
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

@push('styles')
<style>
.pub-idx-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem}
.pub-filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1.25rem}
.pub-search-wrap{position:relative;flex:1;min-width:180px}
.pub-filter-icon{position:absolute;inset-inline-start:.85rem;top:50%;transform:translateY(-50%);pointer-events:none;font-size:.9rem}
.pub-filter-input{width:100%;padding:.6rem .9rem .6rem 2.2rem;border-radius:14px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}
.pub-filter-select{padding:.6rem .9rem;border-radius:14px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem;min-width:150px}

@media(max-width:540px){
    .pub-filter-bar{flex-direction:column}
    .pub-filter-input,.pub-filter-select{width:100%}
}
</style>
@endpush

@push('scripts')
<script>
function openReserveModal(productId, productTitle, maxQty) {
    document.getElementById('modal-product-title').textContent = productTitle;
    document.getElementById('reserve-form').action = '/instant-orders/' + productId + '/reserve';
    const qtyInput = document.getElementById('reserve-qty');
    qtyInput.max = maxQty;
    qtyInput.value = 1;
    openModal('reserve-modal');
}

(function(){
    const search   = document.getElementById('searchInput');
    const status   = document.getElementById('statusFilter');
    const cards    = document.querySelectorAll('.io-filterable');
    const noResult = document.getElementById('noResults');

    function filterCards(){
        const kw  = search.value.toLowerCase();
        const st  = status.value;
        let visible = 0;
        cards.forEach(card => {
            const matchKw = !kw || card.getAttribute('data-title').includes(kw) || card.innerText.toLowerCase().includes(kw);
            const matchSt = !st || card.getAttribute('data-status') === st;
            const show    = matchKw && matchSt;
            card.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        if(noResult) noResult.style.display = visible === 0 ? '' : 'none';
    }

    if(search) search.addEventListener('input', filterCards);
    if(status) status.addEventListener('change', filterCards);
})();
</script>
@endpush
