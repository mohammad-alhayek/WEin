@extends('layouts.admin')
@section('title', $instantOrder->title)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $instantOrder->title }}</h1>
        <span class="badge badge-{{ strtolower($instantOrder->status) }}">{{ __('messages.' . $instantOrder->status) }}</span>
    </div>
    <div class="d-flex gap-1">
        <a href="{{ route('admin.instant-orders.edit', $instantOrder) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
        <a href="{{ route('admin.instant-orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <div class="card">
        <div class="card-header">Product Info</div>
        <div class="card-body">
            @if($instantOrder->image_url)
                <img src="{{ $instantOrder->image_url }}" alt="{{ $instantOrder->title }}" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-bottom:1rem">
            @endif
            <p style="color:var(--text-secondary);margin-bottom:.75rem">{{ $instantOrder->description }}</p>
            <div style="font-size:.9rem;display:flex;flex-direction:column;gap:.5rem">
                <div><strong>{{ __('messages.price') }}:</strong> {{ number_format($instantOrder->price, 2) }}</div>
                <div><strong>{{ __('messages.delivery_price') }}:</strong> {{ number_format($instantOrder->delivery_price, 2) }}</div>
                <div><strong>{{ __('messages.quantity') }}:</strong> {{ $instantOrder->quantity }}</div>
                @if($instantOrder->product_url)
                    <div><a href="{{ $instantOrder->product_url }}" target="_blank" class="btn btn-secondary btn-sm" style="margin-top:.5rem">Product Link ↗</a></div>
                @endif
            </div>
        </div>
    </div>

    @if($instantOrder->specifications)
    <div class="card">
        <div class="card-header">{{ __('messages.specifications') }}</div>
        <div class="card-body">
            <p style="font-size:.9rem;color:var(--text-secondary);white-space:pre-line">{{ $instantOrder->specifications }}</p>
        </div>
    </div>
    @endif
</div>

<div class="d-flex gap-1">
    <a href="{{ route('admin.instant-orders.reservations', $instantOrder) }}" class="btn btn-primary">
        {{ __('messages.reservations') }} ({{ $instantOrder->reservations->count() }})
    </a>
</div>
@endsection
