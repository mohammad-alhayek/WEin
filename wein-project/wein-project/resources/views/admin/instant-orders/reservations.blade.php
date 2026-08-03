@extends('layouts.admin')
@section('title', __('messages.reservations') . ' — ' . $instantOrder->title)

@section('content')
<div class="page-header">
    <div>
        <h1>{{ __('messages.reservations') }}</h1>
        <small class="text-muted">{{ $instantOrder->title }}</small>
    </div>
    <a href="{{ route('admin.instant-orders.show', $instantOrder) }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        @if($reservations->isEmpty())
            <div class="empty-state">{{ __('messages.no_data') }}</div>
        @else
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('messages.customer_name') }}</th>
                            <th>{{ __('messages.phone_number') }}</th>
                            <th>{{ __('messages.location') }}</th>
                            <th>{{ __('messages.quantity') }}</th>
                            <th>{{ __('messages.notes') }}</th>
                            <th>{{ __('messages.created_at') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($reservations as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->customer_name }}</td>
                            <td>{{ $r->phone_number }}</td>
                            <td>{{ $r->location ?? '—' }}</td>
                            <td>{{ $r->quantity }}</td>
                            <td>{{ Str::limit($r->notes, 40) ?? '—' }}</td>
                            <td><small>{{ $r->created_at->format('d M Y H:i') }}</small></td>
                            <td>
                                <form id="del-r-{{ $r->id }}" method="POST" action="{{ route('admin.instant-orders.reservations.destroy', $r) }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('del-r-{{ $r->id }}', '{{ __('messages.confirm_delete') }}')">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
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
