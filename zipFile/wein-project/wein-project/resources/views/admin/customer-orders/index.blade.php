@extends('layouts.admin')

@section('title', __('messages.customer_orders'))

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="customer-header-card mb-4">

        <div class="d-flex justify-content-between align-items-lg-center flex-column flex-lg-row gap-4">

            <div>
                <h1 class="customer-page-title">
                    {{ __('messages.customer_orders') }}
                </h1>

                <p class="customer-page-subtitle mb-0">
                    Manage and monitor customer orders
                </p>
            </div>

            <div class="search-box">
                <input
                    type="text"
                    id="customerSearch"
                    class="form-control"
                    placeholder="🔍 Search customer orders..."
                >
            </div>

        </div>

    </div>


    @if($customerOrders->isEmpty())

        <div class="empty-state-card">

            <div class="empty-icon">
                📦
            </div>

            <h4>{{ __('messages.no_data') }}</h4>

            <p class="text-muted mb-0">
                No customer orders found.
            </p>

        </div>

    @else

        <div class="customer-grid">

            @foreach($customerOrders as $co)

                <div class="customer-card">

                    <div class="customer-card-body">

                        {{-- TOP --}}
                        <div class="d-flex justify-content-between align-items-start mb-4">

                            <div>

                                <div class="customer-name">

                                    {{ $co->customer_name }}

                                </div>

                                <div class="customer-id">

                                    #{{ $co->id }}

                                </div>

                            </div>

                            @if($co->is_updated)

                                <span class="status-badge updated">

                                    {{ __('messages.order_modified') }}

                                </span>

                            @endif

                        </div>


                        {{-- INFO --}}
                        <div class="customer-info-grid">

                            <div class="info-box">
                                <span class="info-label">
                                    {{ __('messages.phone_number') }}
                                </span>

                                <span class="info-value">
                                    {{ $co->phone_number }}
                                </span>
                            </div>

                            <div class="info-box">
                                <span class="info-label">
                                    {{ __('messages.order') }}
                                </span>

                                <span class="info-value">
                                    {{ $co->order->title ?? '—' }}
                                </span>
                            </div>

                            <div class="info-box">
                                <span class="info-label">
                                    {{ __('messages.total_price') }}
                                </span>

                                <span class="info-value">
                                    {{ number_format($co->total_price,2) }}
                                </span>
                            </div>

                        </div>


                        {{-- DATES --}}
                        <div class="meta-section">

                            <div>
                                <small class="text-muted">

                                    {{ __('messages.created_at') }}

                                </small>

                                <div>

                                    {{ $co->created_at->format('d M Y') }}

                                </div>

                            </div>

                            <div>

                                <small class="text-muted">

                                    Modified

                                </small>

                                <div>

                                    @if($co->is_updated)

                                        {{ $co->updated_by_customer_at?->format('d M H:i') }}

                                    @else

                                        —

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- ACTIONS --}}
                        <div class="actions-wrapper">

                            <a
                                href="{{ route('admin.customer-orders.show',$co->id) }}"
                                class="btn-view">

                                {{ __('messages.view') }}

                            </a>


                            <form
                                id="del-co-{{ $co->id }}"
                                method="POST"
                                action="{{ route('admin.customer-orders.destroy',$co->id) }}">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="btn-delete"
                                    onclick="confirmDelete(
                                        'del-co-{{ $co->id }}',
                                        '{{ __('messages.confirm_delete') }}'
                                    )">

                                    {{ __('messages.delete') }}

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        <div class="mt-4">
            {{ $customerOrders->withQueryString()->links() }}
        </div>

    @endif

</div>

@endsection


@push('styles')
<style>

.customer-header-card{

    background:
        linear-gradient(
            135deg,
            #161b22,
            #1c2128
        );

    border:1px solid #30363d;

    border-radius:30px;

    padding:2rem;

    box-shadow:
        0 20px 50px rgba(0,0,0,.25);
}

.customer-page-title{

    color:white;

    font-size:2rem;

    font-weight:800;
}

.customer-page-subtitle{

    color:#8b949e;
}


.search-box input{

    width:320px;

    background:#0d1117;

    border:1px solid #30363d;

    color:white;

    border-radius:16px;

    padding:.9rem 1.2rem;
}


.customer-grid{

    display:grid;

    grid-template-columns:
        repeat(auto-fill,minmax(380px,1fr));

    gap:1.8rem;
}


.customer-card{

    background:
        linear-gradient(
            180deg,
            #161b22,
            #11161c
        );

    border:1px solid #30363d;

    border-radius:28px;

    overflow:hidden;

    transition:.35s;
}


.customer-card:hover{

    transform:
        translateY(-8px);

    border-color:#2563eb;

    box-shadow:
        0 30px 60px rgba(0,0,0,.45);
}


.customer-card-body{

    padding:1.8rem;
}


.customer-name{

    color:white;

    font-size:1.25rem;

    font-weight:700;
}


.customer-id{

    color:#8b949e;

    margin-top:.35rem;
}


.customer-info-grid{

    display:grid;

    gap:1rem;

    margin-bottom:1.5rem;
}


.info-box{

    background:#0d1117;

    border:1px solid #30363d;

    border-radius:16px;

    padding:1rem;
}


.info-label{

    display:block;

    color:#8b949e;

    font-size:.8rem;

    margin-bottom:.35rem;
}


.info-value{

    color:white;

    font-weight:600;
}


.meta-section{

    display:flex;

    justify-content:space-between;

    margin-bottom:1.5rem;

    color:white;
}


.status-badge{

    padding:
        .45rem .9rem;

    border-radius:999px;

    font-size:.75rem;

    font-weight:700;
}

.status-badge.updated{

    background:
        rgba(234,179,8,.15);

    color:#facc15;
}


.actions-wrapper{

    display:flex;

    gap:.75rem;
}


.btn-view,
.btn-delete{

    flex:1;

    border:none;

    border-radius:14px;

    padding:.9rem;

    text-align:center;

    text-decoration:none;

    font-weight:700;
}


.btn-view{

    background:
        linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

    color:white;
}


.btn-delete{

    background:
        rgba(239,68,68,.15);

    color:#f87171;
}


.empty-state-card{

    background:#161b22;

    border:1px solid #30363d;

    border-radius:30px;

    padding:5rem 2rem;

    text-align:center;
}


.empty-icon{

    font-size:4rem;

    margin-bottom:1rem;
}


@media(max-width:992px){

    .customer-grid{
        grid-template-columns:1fr;
    }

    .search-box input{
        width:100%;
    }

}
</style>
@endpush


@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function(){

    const search =
        document.getElementById(
            'customerSearch'
        );

    if(!search) return;

    search.addEventListener('keyup', function(){

        const keyword =
            this.value.toLowerCase();

        document
            .querySelectorAll(
                '.customer-card'
            )
            .forEach(card=>{

                const text =
                    card.innerText.toLowerCase();

                card.style.display =
                    text.includes(keyword)
                        ? ''
                        : 'none';

            });

    });

});

</script>
@endpush