@extends('layouts.public')
@section('title', __('messages.reservation') . ' #' . $reservation->id)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ __('messages.reservation') }} #{{ $reservation->id }}</h1>
        <small class="text-muted">{{ $reservation->instantOrder->title ?? '' }}</small>
    </div>
    <a href="{{ route('instant-orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <div class="card">
        <div class="card-header">Your Info</div>
        <div class="card-body" style="font-size:.9rem;display:flex;flex-direction:column;gap:.5rem">
            <div><strong>{{ __('messages.customer_name') }}:</strong> {{ $reservation->customer_name }}</div>
            <div><strong>{{ __('messages.phone_number') }}:</strong> {{ $reservation->phone_number }}</div>
            <div><strong>{{ __('messages.quantity') }}:</strong> {{ $reservation->quantity }}</div>
            <div><strong>Reservation ID:</strong> #{{ $reservation->id }}</div>
            <div><strong>{{ __('messages.created_at') }}:</strong> {{ $reservation->created_at->format('d M Y H:i') }}</div>
        </div>
    </div>
    @if($reservation->instantOrder)
    <div class="card">
        <div class="card-header">Product</div>
        <div class="card-body" style="font-size:.9rem;display:flex;flex-direction:column;gap:.5rem">
            <div><strong>{{ __('messages.title') }}:</strong> {{ $reservation->instantOrder->title }}</div>
            <div><strong>{{ __('messages.price') }}:</strong> {{ number_format($reservation->instantOrder->price, 2) }}</div>
            <div><strong>{{ __('messages.delivery_price') }}:</strong> {{ number_format($reservation->instantOrder->delivery_price, 2) }}</div>
            <div><strong>Total:</strong>
                {{ number_format(($reservation->instantOrder->price + $reservation->instantOrder->delivery_price) * $reservation->quantity, 2) }}
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Edit Form --}}
<div class="card">
    <div class="card-header">{{ __('messages.edit') }} {{ __('messages.reservation') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('reservations.update', $reservation) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">{{ __('messages.location') }}</label>
                <input type="text" name="location" class="form-control" value="{{ $reservation->location }}">
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.notes') }}</label>
                <textarea name="notes" class="form-control">{{ $reservation->notes }}</textarea>
            </div>
            <div class="d-flex gap-1" style="margin-top:.75rem">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                <form id="del-reservation" method="POST" action="{{ route('reservations.destroy', $reservation) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-danger"
                        onclick="confirmDelete('del-reservation', '{{ __('messages.confirm_delete') }}')">
                        {{ __('messages.delete') }}
                    </button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
