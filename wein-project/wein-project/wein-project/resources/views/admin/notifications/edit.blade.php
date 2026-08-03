@extends('layouts.admin')
@section('title', __('messages.edit') . ' ' . __('messages.notification'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.edit') }} {{ __('messages.notification') }}</h1>
    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.notifications.update', $notification) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Order</label>
                <select name="order_id" class="form-control" required>
                    @foreach($orders as $o)
                        <option value="{{ $o->id }}" {{ old('order_id', $notification->order_id) == $o->id ? 'selected' : '' }}>{{ $o->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.title') }}</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $notification->title) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.message') }}</label>
                <textarea name="message" class="form-control" required>{{ old('message', $notification->message) }}</textarea>
            </div>
            <div class="d-flex gap-1">
                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
