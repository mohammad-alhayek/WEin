@extends('layouts.admin')
@section('title', __('messages.orders'))

@section('content')

<div class="idx-header">
    <h1 class="idx-title">📦 {{ __('messages.orders') }}</h1>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">+ {{ __('messages.create') }}</a>
</div>

{{-- Search + filter bar --}}
<div class="filter-bar">
    <div class="filter-search-wrap">
        <span class="filter-icon">🔍</span>
        <input type="text" id="searchInput" class="filter-input" placeholder="{{ __('messages.search') }}...">
    </div>
    <select id="statusFilter" class="filter-select">
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

<div class="card">
    <div class="card-body" style="padding:0">
        @if($orders->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <div class="table-wrapper">
                <table class="table" id="ordersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.expected_arrival') }}</th>
                            <th>{{ __('messages.tax') }}</th>
                            <th>Customers</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr data-status="{{ $order->status }}">
                            <td>{{ $order->id }}</td>
                            <td><a href="{{ route('admin.orders.show', $order) }}">{{ $order->title }}</a></td>
                            <td>
                                <span class="badge badge-{{ strtolower($order->status) }}">
                                    {{ __('messages.' . $order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->expected_arrival_date?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $order->tax }}%</td>
                            <td>{{ $order->customer_orders_count }}</td>
                            <td>
                                <div class="d-flex gap-1" style="flex-wrap:wrap">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">{{ __('messages.view') }}</a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                                    <form id="del-order-{{ $order->id }}" method="POST" action="{{ route('admin.orders.destroy', $order) }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-order-{{ $order->id }}', '{{ __('messages.confirm_delete') }}')">
                                            {{ __('messages.delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="noResultsRow" style="display:none" class="empty-state">{{ __('messages.no_data') }}</div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
.idx-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem}
.idx-title{margin:0;font-size:1.4rem;font-weight:800}

.filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap;margin-bottom:1rem}
.filter-search-wrap{position:relative;flex:1;min-width:180px}
.filter-icon{position:absolute;inset-inline-start:.9rem;top:50%;transform:translateY(-50%);pointer-events:none}
.filter-input{width:100%;padding:.6rem .9rem .6rem 2.4rem;border-radius:12px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}
.filter-select{padding:.6rem .9rem;border-radius:12px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem;min-width:160px}

@media(max-width:600px){
    .filter-bar{flex-direction:column}
    .filter-input,.filter-select{width:100%}
    .table th:nth-child(4),.table td:nth-child(4),
    .table th:nth-child(5),.table td:nth-child(5){display:none}
}
</style>
@endpush

@push('scripts')
<script>
(function(){
    const search  = document.getElementById('searchInput');
    const status  = document.getElementById('statusFilter');
    const rows    = document.querySelectorAll('#ordersTable tbody tr');
    const noRows  = document.getElementById('noResultsRow');

    function filterRows(){
        const kw  = search.value.toLowerCase();
        const st  = status.value;
        let visible = 0;
        rows.forEach(row => {
            const matchKw = !kw  || row.innerText.toLowerCase().includes(kw);
            const matchSt = !st  || row.getAttribute('data-status') === st;
            const show    = matchKw && matchSt;
            row.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        if(noRows) noRows.style.display = visible === 0 ? '' : 'none';
    }

    search.addEventListener('input', filterRows);
    status.addEventListener('change', filterRows);
})();
</script>
@endpush
