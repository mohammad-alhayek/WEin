@extends('layouts.public')
@section('title', 'Customer Order #' . $customerOrder->id)

@section('content')
{{-- Header --}}
<div class="page-header" style="flex-wrap:wrap;gap:.75rem">
    <div>
        <h1 style="margin:0">Customer Order #{{ $customerOrder->id }}</h1>
        <span style="color:var(--text-secondary);font-size:.9rem">{{ $customerOrder->order->title ?? '' }}</span>
    </div>
    <a href="{{ url('/') }}" class="btn btn-secondary">← {{ __('messages.back') }}</a>
</div>

{{-- Top grid: info + pricing --}}
<div class="co-public-grid">

    {{-- Customer Info --}}
    <div class="card">
        <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">
            👤 {{ __('messages.customer_name') }}
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
            <div class="co-info-row"><span class="co-info-label">{{ __('messages.customer_name') }}</span><span>{{ $customerOrder->customer_name }}</span></div>
            <div class="co-info-row"><span class="co-info-label">{{ __('messages.phone_number') }}</span><span>{{ $customerOrder->phone_number }}</span></div>
            <div class="co-info-row"><span class="co-info-label">{{ __('messages.location') }}</span><span>{{ $customerOrder->location ?? '—' }}</span></div>
            <div class="co-info-row"><span class="co-info-label">Order ID</span><span>#{{ $customerOrder->id }}</span></div>
            <div class="co-info-row"><span class="co-info-label">{{ __('messages.created_at') }}</span><span>{{ $customerOrder->created_at->format('d M Y') }}</span></div>
        </div>
    </div>

    {{-- Pricing --}}
    <div class="card">
        <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">
            💰 Pricing
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:.6rem;font-size:.9rem">
            <div class="co-info-row">
                <span class="co-info-label">{{ __('messages.price') }}</span>
                <span style="{{ $customerOrder->price > 0 ? 'color:var(--success,#22c55e);font-weight:700' : 'color:var(--text-muted);font-style:italic' }}">
                    @if($customerOrder->price > 0)
                        {{ number_format($customerOrder->price, 2) }} ر.س
                    @else
                        {{ __('messages.price_not_set') }}
                    @endif
                </span>
            </div>
            <div class="co-info-row"><span class="co-info-label">{{ __('messages.delivery_price') }}</span><span>{{ number_format($customerOrder->delivery_price, 2) }} ر.س</span></div>
            <div class="co-info-row"><span class="co-info-label">{{ __('messages.tax') }}</span><span>{{ number_format($customerOrder->order->tax ?? 0, 2) }}%</span></div>
            <hr style="border-color:var(--border);margin:.25rem 0">
            <div class="co-info-row" style="font-size:1rem">
                <span style="font-weight:700">{{ __('messages.total_price') }}</span>
                <span style="font-weight:800;color:var(--primary,#3b82f6)">{{ number_format($customerOrder->total_price, 2) }} ر.س</span>
            </div>
        </div>
    </div>

</div>

{{-- Cart URL + Notes --}}
@if($customerOrder->cart_url || $customerOrder->notes)
<div class="card" style="margin-top:1rem">
    <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">📋 Order Details</div>
    <div class="card-body" style="display:flex;flex-direction:column;gap:.75rem;font-size:.9rem">
        @if($customerOrder->cart_url)
            <div>
                <strong>{{ __('messages.cart_url') }}:</strong>
                <a href="{{ $customerOrder->cart_url }}" target="_blank" style="color:var(--primary,#3b82f6);word-break:break-all">{{ $customerOrder->cart_url }}</a>
            </div>
        @endif
        @if($customerOrder->notes)
            <div>
                <strong>{{ __('messages.notes') }}:</strong>
                <p style="margin-top:.25rem;color:var(--text-secondary)">{{ $customerOrder->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endif

{{-- Edit form (only if order is open) --}}
@if($customerOrder->order && $customerOrder->order->isOpen())
<div class="card" style="margin-top:1rem">
    <div class="card-header" style="background:var(--bg-secondary);padding:.75rem 1rem;font-weight:700;border-bottom:1px solid var(--border)">✏️ {{ __('messages.edit') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('customer-orders.update', $customerOrder->id) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">{{ __('messages.cart_url') }}</label>
                    <input type="url" name="cart_url" class="form-control" value="{{ old('cart_url', $customerOrder->cart_url) }}" placeholder="https://...">
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('messages.location') }}</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $customerOrder->location) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('messages.notes') }}</label>
                <textarea name="notes" class="form-control">{{ old('notes', $customerOrder->notes) }}</textarea>
            </div>
            <div class="d-flex gap-1" style="flex-wrap:wrap">
                <button type="submit" class="btn btn-primary">💾 {{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Chatbot button --}}
<div class="mb-3" style="margin-top:1.25rem">
    <button type="button" id="openChatBtn" class="btn btn-secondary" data-order-id="{{ $customerOrder->id }}">
        💬 استفسر عن طلبيتي
    </button>
</div>

{{-- Chat modal --}}
<div id="chatModal" class="chat-modal" style="display:none">
    <div class="chat-header">
        <span>🤖 مساعد WEIN الذكي</span>
        <button type="button" id="closeChatBtn">&times;</button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="bot-message">جاري جلب تفاصيل طلبيتك...</div>
    </div>
</div>

{{-- Delete form --}}
@if($customerOrder->order && $customerOrder->order->isOpen())
<div style="margin-top:1.5rem;padding-top:1rem;border-top:1px solid var(--border)">
    <form id="del-my-order" method="POST" action="{{ route('customer-orders.destroy', $customerOrder->id) }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-sm"
            onclick="confirmDelete('del-my-order', '{{ __('messages.confirm_delete') }}')">
            🗑 {{ __('messages.delete') }}
        </button>
    </form>
</div>
@endif

@push('styles')
<style>
.co-public-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem}
.co-info-row{display:flex;justify-content:space-between;align-items:flex-start;gap:.5rem;flex-wrap:wrap}
.co-info-label{color:var(--text-muted);font-size:.82rem;flex-shrink:0}

.chat-modal{position:fixed;bottom:20px;inset-inline-end:20px;width:340px;background:var(--bg-secondary,#161b22);border:1px solid var(--border,#30363d);border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.5);z-index:1050;overflow:hidden}
.chat-header{background:var(--bg-tertiary,#21262d);color:#fff;padding:10px 15px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--border,#30363d);font-size:.9rem}
.chat-header button{background:none;border:none;color:#fff;font-size:1.2rem;cursor:pointer}
.chat-body{padding:15px;color:var(--text-secondary,#c9d1d9);font-size:.85rem;line-height:1.7;max-height:320px;overflow-y:auto;white-space:pre-line}
.bot-message{background:var(--bg-primary,#0d1117);border:1px solid var(--border,#30363d);padding:10px 12px;border-radius:10px}

@media(max-width:640px){
    .co-public-grid{grid-template-columns:1fr}
    .chat-modal{width:calc(100% - 2rem);inset-inline-end:1rem;inset-inline-start:1rem}
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openChatBtn = document.getElementById('openChatBtn');
    const chatModal   = document.getElementById('chatModal');
    const closeChatBtn= document.getElementById('closeChatBtn');
    const chatBody    = document.getElementById('chatBody');

    if (openChatBtn && chatModal) {
        openChatBtn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            chatModal.style.display = 'block';
            chatBody.innerHTML = '<div class="bot-message">مرحباً... جاري مراجعة تفاصيل طلبيتك ⏳</div>';

            const chatUrl = "{{ route('customer-orders.chat-status', ':id') }}".replace(':id', orderId);

            fetch(chatUrl, {
                method: 'GET',
                headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
            })
            .then(r => { if (!r.ok) throw new Error('Server error'); return r.json(); })
            .then(data => {
                chatBody.innerHTML = data.success
                    ? `<div class="bot-message">${data.message}</div>`
                    : `<div class="bot-message" style="color:#f87171">عذراً، حدث خطأ أثناء جلب بيانات الطلب.</div>`;
            })
            .catch(() => {
                chatBody.innerHTML = `<div class="bot-message" style="color:#f87171">تعذر الاتصال بالخادم.</div>`;
            });
        });

        if (closeChatBtn) closeChatBtn.addEventListener('click', () => chatModal.style.display = 'none');
    }
});
</script>
@endpush

@endsection
