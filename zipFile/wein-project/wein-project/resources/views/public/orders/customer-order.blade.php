@extends('layouts.public')
@section('title', 'Customer Order #' . $customerOrder->id)

@section('content')
{{-- Header --}}
<div class="page-header">
    <div>
        <h1>Customer Order #{{ $customerOrder->id }}</h1>
        <span style="color:var(--text-secondary)">{{ $customerOrder->mainOrder->title ?? '' }}</span>
    </div>
<a href="{{ url('/') }}" class="btn btn-secondary">← Back</a></div>

{{-- تفاصيل الطلب وعرض البيانات --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
    <div class="card">
        <div class="card-body">
            <h3 style="font-size: 1rem; margin-bottom: 1rem; color: var(--text-muted);">messages.customer_info</h3>
            <p><strong>Customer Name:</strong> {{ $customerOrder->customer_name }}</p>
            <p><strong>Phone Number:</strong> {{ $customerOrder->phone_number }}</p>
            <p><strong>Location:</strong> {{ $customerOrder->location }}</p>
            <p><strong>Order ID:</strong> #{{ $customerOrder->id }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 style="font-size: 1rem; margin-bottom: 1rem; color: var(--text-muted);">messages.pricing</h3>
            <p><strong>Price:</strong> {{ number_format($customerOrder->price, 2) }}</p>
            <p><strong>Delivery Price:</strong> {{ number_format($customerOrder->deliveryPrice ?? 20, 2) }}</p>
            <p><strong>Tax (%):</strong> {{ number_format($customerOrder->mainOrder->tax ?? 15, 2) }}%</p>
            <hr style="border-color: #30363d; margin: 10px 0;">
            <p><strong>Total Price:</strong> {{ number_format($customerOrder->total_price ?? 85.10, 2) }}</p>
        </div>
    </div>
</div>

{{-- زر استفسار عن طلبيتي --}}
<div class="mb-3">
    <button type="button" id="openChatBtn" class="btn btn-primary" data-order-id="{{ $customerOrder->id }}">
        💬 استفسر عن طلبيتي
    </button>
</div>

{{-- صندوق محادثة المساعد الذكي (Chat Modal) --}}
<div id="chatModal" class="chat-modal" style="display: none;">
    <div class="chat-header">
        <span>🤖 مساعد WEIN الذكي</span>
        <button type="button" id="closeChatBtn">&times;</button>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="bot-message">جاري جلب تفاصيل طلبيتك...</div>
    </div>
</div>

{{-- تنسيقات نافذة الشات --}}
@push('styles')
<style>
.chat-modal {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 320px;
    background: #161b22;
    border: 1px solid #30363d;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    z-index: 1050;
    overflow: hidden;
}
.chat-header {
    background: #21262d;
    color: #fff;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #30363d;
    font-size: 0.9rem;
}
.chat-header button {
    background: none;
    border: none;
    color: #fff;
    font-size: 1.2rem;
    cursor: pointer;
}
.chat-body {
    padding: 15px;
    color: #c9d1d9;
    font-size: 0.85rem;
    line-height: 1.6;
    max-height: 300px;
    overflow-y: auto;
}
.bot-message {
    background: #0d1117;
    border: 1px solid #30363d;
    padding: 10px 12px;
    border-radius: 10px;
}
</style>
@endpush

{{-- JavaScript الخاص بتفعيل الشات --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const openChatBtn = document.getElementById('openChatBtn');
    const chatModal = document.getElementById('chatModal');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const chatBody = document.getElementById('chatBody');

    if(openChatBtn && chatModal) {
        openChatBtn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            chatModal.style.display = 'block';
            chatBody.innerHTML = '<div class="bot-message">مرحباً... جاري مراجعة تفاصيل طلبيتك ⏳</div>';

            // توليد الرابط بطريقة آمنة وصحيحة تماماً عبر لارافيل
            const chatUrl = "{{ route('customer-orders.chat-status', ':id') }}".replace(':id', orderId);

            fetch(chatUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server response failed');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    let formattedMsg = data.message.replace(/\n/g, '<br>');
                    chatBody.innerHTML = `<div class="bot-message">${formattedMsg}</div>`;
                } else {
                    chatBody.innerHTML = `<div class="bot-message text-danger">عذراً، حدث خطأ أثناء جلب بيانات الطلب.</div>`;
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                chatBody.innerHTML = `<div class="bot-message text-danger">تعذر الاتصال بالخادم. تحقق من مسار الـ Route.</div>`;
            });
        });

        if(closeChatBtn) {
            closeChatBtn.addEventListener('click', function() {
                chatModal.style.display = 'none';
            });
        }
    }
});
</script>
@endsection