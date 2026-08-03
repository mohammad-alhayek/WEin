@extends('layouts.admin')
@section('title', __('messages.orders'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.orders') }}</h1>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">+ {{ __('messages.create') }}</a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        @if($orders->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <div class="table-wrapper">
                <table class="table">
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
                        <tr>
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
                                <div class="d-flex gap-1">
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
        @endif
    </div>
</div>
@endsection
