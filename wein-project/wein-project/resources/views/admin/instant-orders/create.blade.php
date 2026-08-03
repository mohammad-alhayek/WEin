@extends('layouts.admin')
@section('title', __('messages.add') . ' ' . __('messages.instant_order'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.add') }} {{ __('messages.instant_order') }}</h1>
    <a href="{{ route('admin.instant-orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div class="card" style="max-width:700px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.instant-orders.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">{{ __('messages.title') }}</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')<p class="form-error">{{ $message }}</p>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.description') }}</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.product_url') }}</label>
                    <input type="url" name="product_url" class="form-control" value="{{ old('product_url') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.image_url') }}</label>
                    <input type="url" name="image_url" class="form-control" value="{{ old('image_url') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.price') }}</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}" step="0.01" min="0" required>
                    @error('price')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.delivery_price') }}</label>
                    <input type="number" name="delivery_price" class="form-control" value="{{ old('delivery_price', 0) }}" step="0.01" min="0" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.quantity') }}</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="0" required>
                    @error('quantity')<p class="form-error">{{ $message }}</p>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.status') }}</label>
                    <select name="status" class="form-control">
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>{{ __('messages.' . $s) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.specifications') }}</label>
                <textarea name="specifications" class="form-control">{{ old('specifications') }}</textarea>
            </div>
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                <a href="{{ route('admin.instant-orders.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
