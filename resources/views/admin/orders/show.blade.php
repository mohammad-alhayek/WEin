@extends('layouts.admin')
@section('title', $order->title)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ $order->title }}</h1>
        <span class="badge badge-{{ strtolower($order->status) }}">{{ __('messages.' . $order->status) }}</span>
    </div>
    <div class="d-flex gap-1">
        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
    </div>
</div>

{{-- Order Info --}}
<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;margin-bottom:1.5rem">
    <div class="card">
        <div class="card-header">Order Details</div>
        <div class="card-body">
            @if($order->description)
                <p style="margin-bottom:.75rem;color:var(--text-secondary)">{{ $order->description }}</p>
            @endif
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;font-size:.9rem">
                <div><strong>{{ __('messages.expected_arrival') }}:</strong> {{ $order->expected_arrival_date?->format('d M Y') ?? '—' }}</div>
                <div><strong>{{ __('messages.tax') }}:</strong> {{ $order->tax }}%</div>
                <div><strong>Created:</strong> {{ $order->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>
    </div>

    {{-- Change Status --}}
    <div class="card">
        <div class="card-header">{{ __('messages.change_status') }}</div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                @csrf @method('PATCH')
                <div class="form-group">
                    <select name="status" class="form-control">
                        @foreach(\App\Models\Order::STATUSES as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ __('messages.' . $s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">{{ __('messages.save') }}</button>
            </form>
        </div>
    </div>
</div>

{{-- Notifications --}}
@if($notifications->count())
<div class="mb-3">
    <h3 style="margin-bottom:.75rem">🔔 {{ __('messages.notifications') }}</h3>
    @foreach($notifications as $n)
        <div class="notification-item">
            <strong>{{ $n->title }}</strong>
            <p style="margin-top:.25rem;font-size:.9rem;color:var(--text-secondary)">{{ $n->message }}</p>
            <small class="text-muted">{{ $n->created_at->format('d M Y H:i') }}</small>
        </div>
    @endforeach
</div>
@endif

{{-- Customer Orders --}}
<div class="card">
    <div class="card-header">
        <span>👤 {{ __('messages.customer_orders') }} ({{ $customerOrders->count() }})</span>
    </div>
    <div class="card-body" style="padding:0">
        @if($customerOrders->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('messages.customer_name') }}</th>
                            <th>{{ __('messages.phone_number') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.delivery_price') }}</th>
                            <th>{{ __('messages.total_price') }}</th>
                            <th>{{ __('messages.location') }}</th>
                            <th>Status</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($customerOrders as $co)
                        <tr>
                            <td>
                                {{ $co->customer_name }}
                                @if($co->is_updated)
                                    <span class="badge badge-updated">{{ __('messages.order_modified') }}</span>
                                @endif
                            </td>
                            <td>{{ $co->phone_number }}</td>
                            <td>{{ number_format($co->price, 2) }}</td>
                            <td>{{ number_format($co->delivery_price, 2) }}</td>
                            <td><strong>{{ number_format($co->total_price, 2) }}</strong></td>
                            <td>{{ $co->location ?? '—' }}</td>
                            <td>
                                @if($co->cart_url)
                                    <a href="{{ $co->cart_url }}" target="_blank" class="btn btn-secondary btn-sm">Cart ↗</a>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.customer-orders.show', $co) }}" class="btn btn-secondary btn-sm">{{ __('messages.view') }}</a>
                                    <form id="del-co-{{ $co->id }}" method="POST" action="{{ route('admin.customer-orders.destroy', $co) }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-co-{{ $co->id }}', '{{ __('messages.confirm_delete') }}')">
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
        @endif
    </div>
</div>
@endsection
