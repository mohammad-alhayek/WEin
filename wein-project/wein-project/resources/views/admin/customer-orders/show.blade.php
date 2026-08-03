@extends('layouts.admin')
@section('title', 'Customer Order — ' . $customerOrder->customer_name)

@section('content')
<div class="page-header">
    <h1>{{ $customerOrder->customer_name }}</h1>
    <a href="{{ route('admin.customer-orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
    <div class="card">
        <div class="card-header">Customer Info</div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
                <div><strong>{{ __('messages.customer_name') }}:</strong> {{ $customerOrder->customer_name }}</div>
                <div><strong>{{ __('messages.phone_number') }}:</strong> {{ $customerOrder->phone_number }}</div>
                <div><strong>{{ __('messages.location') }}:</strong> {{ $customerOrder->location ?? '—' }}</div>
                <div><strong>Order:</strong> <a href="{{ route('admin.orders.show', $customerOrder->orders_id) }}">{{ $customerOrder->order->title ?? '—' }}</a></div>
                <div><strong>{{ __('messages.created_at') }}:</strong> {{ $customerOrder->created_at->format('d M Y H:i') }}</div>
                @if($customerOrder->is_updated)
                    <div class="alert alert-warning" style="margin-top:.5rem">
                        ⚠ {{ __('messages.order_modified') }}: {{ $customerOrder->updated_by_customer_at?->format('d M Y H:i') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Pricing</div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
                <div><strong>{{ __('messages.price') }}:</strong> {{ number_format($customerOrder->price, 2) }}</div>
                <div><strong>{{ __('messages.delivery_price') }}:</strong> {{ number_format($customerOrder->delivery_price, 2) }}</div>
                <div><strong>{{ __('messages.tax') }}:</strong> {{ $customerOrder->tax }}%</div>
                <hr style="border-color:var(--border)">
                <div style="font-size:1.1rem"><strong>{{ __('messages.total_price') }}:</strong> {{ number_format($customerOrder->total_price, 2) }}</div>
            </div>
        </div>
    </div>
</div>

@if($customerOrder->cart_url || $customerOrder->notes)
<div class="card" style="margin-top:1.25rem">
    <div class="card-header">Order Details</div>
    <div class="card-body">
        @if($customerOrder->cart_url)
            <div style="margin-bottom:.75rem">
                <strong>{{ __('messages.cart_url') }}:</strong>
                <a href="{{ $customerOrder->cart_url }}" target="_blank">{{ $customerOrder->cart_url }}</a>
            </div>
        @endif
        @if($customerOrder->notes)
            <div>
                <strong>{{ __('messages.notes') }}:</strong>
                <p style="margin-top:.3rem;color:var(--text-secondary)">{{ $customerOrder->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endif
@endsection
