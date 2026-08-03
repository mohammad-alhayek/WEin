@extends('layouts.admin')
@section('title', __('messages.notifications'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.notifications') }}</h1>
    <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary">+ {{ __('messages.create') }}</a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        @if($notifications->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.title') }}</th>
                            <th>{{ __('messages.message') }}</th>
                            <th>Order</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $n)
                        <tr>
                            <td>{{ $n->id }}</td>
                            <td>{{ $n->title }}</td>
                            <td>{{ Str::limit($n->message, 60) }}</td>
                            <td>{{ $n->order->title ?? '—' }}</td>
                            <td><small>{{ $n->created_at->format('d M Y') }}</small></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.notifications.edit', $n) }}" class="btn btn-warning btn-sm">{{ __('messages.edit') }}</a>
                                    <form id="del-n-{{ $n->id }}" method="POST" action="{{ route('admin.notifications.destroy', $n) }}">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('del-n-{{ $n->id }}', '{{ __('messages.confirm_delete') }}')">
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
            <div style="padding:1rem">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>
@endsection
