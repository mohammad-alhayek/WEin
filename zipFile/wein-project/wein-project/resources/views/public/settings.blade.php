@extends('layouts.public')
@section('title', __('messages.settings'))

@section('content')
<div class="page-header">
    <h1>⚙ {{ __('messages.settings') }}</h1>
</div>

<div class="card" style="max-width:520px">
    <div class="card-body">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf

            {{-- Language --}}
            <div class="form-group">
                <label class="form-label">{{ __('messages.language') }}</label>
                <select name="language" class="form-control">
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('messages.english') }} (English)</option>
                    <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }}>{{ __('messages.arabic') }} (العربية)</option>
                </select>
            </div>

          

            {{-- View Mode --}}
            <div class="form-group">
                <label class="form-label">{{ __('messages.view_mode') }}</label>
                <select name="view" class="form-control">
                    <option value="card" {{ request()->cookie('wein_view', 'card') === 'card' ? 'selected' : '' }}>⊞ {{ __('messages.card_view') }}</option>
                    <option value="list" {{ request()->cookie('wein_view') === 'list' ? 'selected' : '' }}>☰ {{ __('messages.list_view') }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin-top:.5rem">{{ __('messages.save') }}</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Live theme preview
document.getElementById('theme-select').addEventListener('change', function() {
    document.documentElement.setAttribute('data-theme', this.value);
});
</script>
@endsection
