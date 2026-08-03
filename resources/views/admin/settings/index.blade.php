@extends('layouts.admin')
@section('title', __('messages.site_settings'))

@section('content')
<div class="page-header">
    <h1>{{ __('messages.site_settings') }}</h1>
</div>

<div class="card" style="max-width:540px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.site-settings.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">{{ __('messages.site_name') }}</label>
                <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings->site_name) }}" required>
                <small class="text-muted" style="display:block;margin-top:.35rem">
                    {{ app()->getLocale() === 'ar' ? 'سيظهر هذا الاسم في جميع صفحات الموقع' : 'This name appears on all pages of the site' }}
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('messages.admin_name') }}</label>
                <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name', $settings->admin_name) }}" placeholder="{{ app()->getLocale() === 'ar' ? 'اسم المندوب' : 'Agent full name' }}">
            </div>

            <div class="form-group">
                <label class="form-label">{{ __('messages.admin_phone') }}</label>
                <input type="text" name="admin_phone" class="form-control" value="{{ old('admin_phone', $settings->admin_phone) }}" placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: 0501234567' : 'e.g. 0501234567' }}" dir="ltr">
                <small class="text-muted" style="display:block;margin-top:.35rem">
                    {{ app()->getLocale() === 'ar' ? 'سيُعرض هذا الرقم لعملائك عند الضغط على زر التواصل' : 'Shown to customers when they tap the Contact button' }}
                </small>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="margin-top:.5rem">
                {{ __('messages.save') }}
            </button>
        </form>
    </div>
</div>
@endsection
