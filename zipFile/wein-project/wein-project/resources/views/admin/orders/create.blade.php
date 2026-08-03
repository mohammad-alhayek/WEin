@extends('layouts.admin')
@section('title', __('messages.create') . ' ' . __('messages.order'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.create') }} {{ __('messages.order') }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div class="card" style="max-width:680px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.orders.store') }}">
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
                    <label class="form-label">{{ __('messages.expected_arrival') }}</label>
                    <input type="date" name="expected_arrival_date" class="form-control" value="{{ old('expected_arrival_date') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.tax') }}</label>
                    <input type="number" name="tax" class="form-control" value="{{ old('tax', 0) }}" step="0.01" min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.status') }}</label>
                <select name="status" class="form-control">
                    @foreach($statuses as $s)
                        <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>{{ __('messages.' . $s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex gap-1" style="margin-top:1rem">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
