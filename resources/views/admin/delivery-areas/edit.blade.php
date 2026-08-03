@extends('layouts.admin')
@section('title', __('messages.edit') . ' ' . __('messages.delivery_area'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.edit') }} {{ __('messages.delivery_area') }}</h1>
    <a href="{{ route('admin.delivery-areas.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div class="card" style="max-width:480px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.delivery-areas.update', $deliveryArea) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">{{ __('messages.city_name') }}</label>
                <input type="text" name="city_name" class="form-control" value="{{ old('city_name', $deliveryArea->city_name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.delivery_price') }}</label>
                <input type="number" name="delivery_price" class="form-control" value="{{ old('delivery_price', $deliveryArea->delivery_price) }}" step="0.01" min="0" required>
            </div>
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                <a href="{{ route('admin.delivery-areas.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
