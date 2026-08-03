@extends('layouts.public')
@section('title', __('messages.orders'))

@section('content')

<div class="pub-idx-header">
    <div>
        <h1 style="margin:0;font-size:1.6rem;font-weight:800">📦 {{ __('messages.orders') }}</h1>
        <p style="color:var(--text-muted);margin:.25rem 0 0">{{ __('messages.manage_orders') }}</p>
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
        <option value="Open">{{ __('messages.Open') }}</option>
        <option value="Sorting">{{ __('messages.Sorting') }}</option>
        <option value="Sent">{{ __('messages.Sent') }}</option>
        <option value="Shipping">{{ __('messages.Shipping') }}</option>
        <option value="Delivery">{{ __('messages.Delivery') }}</option>
        <option value="Delivered">{{ __('messages.Delivered') }}</option>
        <option value="Closed">{{ __('messages.Closed') }}</option>
    </select>
</div>

@if($orders->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p>{{ __('messages.no_data') }}</p>
    </div>
@else
    <div id="ordersContainer" style="display:flex;flex-direction:column;gap:1rem">
        @foreach($orders as $order)
        <div class="card pub-order-card" data-status="{{ $order->status }}" data-title="{{ strtolower($order->title) }} {{ strtolower($order->description ?? '') }}">
            <div class="card-body">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap">
                    <div style="flex:1;min-width:0">
                        <div class="d-flex align-center gap-1" style="margin-bottom:.5rem;flex-wrap:wrap">
                            <h3 style="font-size:1.1rem;margin:0">{{ $order->title }}</h3>
                            <span class="badge badge-{{ strtolower($order->status) }}">{{ __('messages.' . $order->status) }}</span>
                        </div>
                        @if($order->description)
                            <p style="color:var(--text-secondary);font-size:.9rem;margin-bottom:.5rem">{{ Str::limit($order->description, 120) }}</p>
                        @endif
                        <div style="font-size:.8rem;color:var(--text-muted);display:flex;gap:1.25rem;flex-wrap:wrap">
                            @if($order->expected_arrival_date)
                                <span>📅 {{ __('messages.expected_arrival') }}: {{ $order->expected_arrival_date->format('d M Y') }}</span>
                            @endif
                            <span>👥 {{ $order->customer_orders_count }} {{ __('messages.customer_orders') }}</span>
                            <span>🧾 {{ __('messages.tax') }}: {{ $order->tax }}%</span>
                        </div>
                    </div>
                    <div style="flex-shrink:0">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                            {{ __('messages.view') }} →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div id="noResults" style="display:none" class="empty-state">
        <p>{{ __('messages.no_orders_found') }}</p>
    </div>
@endif

@endsection

@push('styles')
<style>
.pub-idx-header{margin-bottom:1.25rem}
.pub-filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1.25rem}
.pub-search-wrap{position:relative;flex:1;min-width:180px}
.pub-filter-icon{position:absolute;inset-inline-start:.85rem;top:50%;transform:translateY(-50%);pointer-events:none;font-size:.9rem}
.pub-filter-input{width:100%;padding:.6rem .9rem .6rem 2.2rem;border-radius:14px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}
.pub-filter-select{padding:.6rem .9rem;border-radius:14px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem;min-width:150px}

.pub-order-card{transition:.2s}
.pub-order-card:hover{border-color:var(--primary,#3b82f6)}

@media(max-width:540px){
    .pub-filter-bar{flex-direction:column}
    .pub-filter-input,.pub-filter-select{width:100%}
}
</style>
@endpush

@push('scripts')
<script>
(function(){
    const search   = document.getElementById('searchInput');
    const status   = document.getElementById('statusFilter');
    const cards    = document.querySelectorAll('.pub-order-card');
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
