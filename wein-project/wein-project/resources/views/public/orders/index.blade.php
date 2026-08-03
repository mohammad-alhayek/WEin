@extends('layouts.public')
@section('title', __('messages.orders'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.orders') }}</h1>
</div>

@if($orders->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p>{{ __('messages.no_data') }}</p>
    </div>
@else
    <div style="display:flex;flex-direction:column;gap:1rem">
    @foreach($orders as $order)
        <div class="card">
            <div class="card-body">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap">
                    <div style="flex:1">
                        <div class="d-flex align-center gap-1" style="margin-bottom:.5rem">
                            <h3 style="font-size:1.1rem">{{ $order->title }}</h3>
                            <span class="badge badge-{{ strtolower($order->status) }}">{{ __('messages.' . $order->status) }}</span>
                        </div>
                        @if($order->description)
                            <p style="color:var(--text-secondary);font-size:.9rem;margin-bottom:.5rem">{{ Str::limit($order->description, 120) }}</p>
                        @endif
                        <div style="font-size:.8rem;color:var(--text-muted);display:flex;gap:1.5rem;flex-wrap:wrap">
                            @if($order->expected_arrival_date)
                                <span>📅 {{ __('messages.expected_arrival') }}: {{ $order->expected_arrival_date->format('d M Y') }}</span>
                            @endif
                            <span>👥 {{ $order->customer_orders_count }} {{ __('messages.customer_orders') }}</span>
                            <span>🧾 {{ __('messages.tax') }}: {{ $order->tax }}%</span>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                            {{ __('messages.view') }} →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endif
@endsection
