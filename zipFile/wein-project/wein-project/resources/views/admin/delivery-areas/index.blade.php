@extends('layouts.admin')
@section('title', __('messages.delivery_areas'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.delivery_areas') }}</h1>
    <a href="{{ route('admin.delivery-areas.create') }}" class="btn btn-primary">+ {{ __('messages.add') }}</a>
</div>

<div class="card" style="max-width:640px">
    <div class="card-body" style="padding:0">
        @if($areas->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <table class="table">
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
                            <div class="d-flex gap-1">
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
        @endif
    </div>
</div>
@endsection
