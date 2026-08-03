@extends('layouts.admin')
@section('title', __('messages.instant_orders'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.instant_orders') }}</h1>
    <a href="{{ route('admin.instant-orders.create') }}" class="btn btn-primary">+ {{ __('messages.add') }}</a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        @if($products->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.price') }}</th>
                            <th>{{ __('messages.quantity') }}</th>
                            <th>Reservations</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td>
                                <span class="badge badge-{{ strtolower($product->status) }}">
                                    {{ __('messages.' . $product->status) }}
                                </span>
                            </td>
                            <td>{{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->reservations_count }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.instant-orders.show', $product) }}" class="btn btn-secondary btn-sm">{{ __('messages.view') }}</a>
                                    <a href="{{ route('admin.instant-orders.edit', $product) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                                    <a href="{{ route('admin.instant-orders.reservations', $product) }}" class="btn btn-secondary btn-sm">{{ __('messages.reservations') }}</a>
                                    <form id="del-io-{{ $product->id }}" method="POST" action="{{ route('admin.instant-orders.destroy', $product) }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-io-{{ $product->id }}', '{{ __('messages.confirm_delete') }}')">
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
