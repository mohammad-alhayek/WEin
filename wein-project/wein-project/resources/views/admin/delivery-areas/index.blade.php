@extends('layouts.admin')
@section('title', __('messages.delivery_areas'))

@section('content')

<div class="idx-header">
    <h1 class="idx-title">🗺 {{ __('messages.delivery_areas') }}</h1>
    <a href="{{ route('admin.delivery-areas.create') }}" class="btn btn-primary">+ {{ __('messages.add') }}</a>
</div>

{{-- Search bar --}}
<div class="filter-bar" style="margin-bottom:1rem">
    <div class="filter-search-wrap" style="max-width:400px">
        <span class="filter-icon">🔍</span>
        <input type="text" id="searchInput" class="filter-input" placeholder="{{ __('messages.search') }}...">
    </div>
</div>

<div class="card" style="max-width:720px">
    <div class="card-body" style="padding:0">
        @if($areas->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <table class="table" id="areasTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('messages.city_name') }}</th>
                        <th>{{ __('messages.delivery_price') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($areas as $area)
                    <tr>
                        <td>{{ $area->id }}</td>
                        <td>{{ $area->city_name }}</td>
                        <td>{{ number_format($area->delivery_price, 2) }}</td>
                        <td>
                            <div class="d-flex gap-1" style="flex-wrap:wrap">
                                <a href="{{ route('admin.delivery-areas.edit', $area) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                                <form id="del-da-{{ $area->id }}" method="POST" action="{{ route('admin.delivery-areas.destroy', $area) }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('del-da-{{ $area->id }}', '{{ __('messages.confirm_delete') }}')">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div id="noResultsRow" style="display:none" class="empty-state">{{ __('messages.no_data') }}</div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
.idx-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem}
.idx-title{margin:0;font-size:1.4rem;font-weight:800}

.filter-bar{display:flex;gap:.75rem;align-items:center;flex-wrap:wrap}
.filter-search-wrap{position:relative;flex:1}
.filter-icon{position:absolute;inset-inline-start:.9rem;top:50%;transform:translateY(-50%);pointer-events:none}
.filter-input{width:100%;padding:.6rem .9rem .6rem 2.4rem;border-radius:12px;border:1px solid var(--border);background:var(--bg-secondary);color:var(--text-primary);font-size:.9rem}

@media(max-width:600px){
    .filter-search-wrap{max-width:100%!important;width:100%}
}
</style>
@endpush

@push('scripts')
<script>
(function(){
    const search = document.getElementById('searchInput');
    const rows   = document.querySelectorAll('#areasTable tbody tr');
    const noRows = document.getElementById('noResultsRow');

    search.addEventListener('input', function(){
        const kw = this.value.toLowerCase();
        let visible = 0;
        rows.forEach(row => {
            const show = !kw || row.innerText.toLowerCase().includes(kw);
            row.style.display = show ? '' : 'none';
            if(show) visible++;
        });
        if(noRows) noRows.style.display = visible === 0 ? '' : 'none';
    });
})();
</script>
@endpush
