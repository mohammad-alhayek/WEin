/* =============================================
   WEIN - Main JavaScript
   ============================================= */

// ── Theme ──────────────────────────────────────
(function () {
    const saved = getCookie('wein_theme') || 'light';
    document.documentElement.setAttribute('data-theme', saved);
})();

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
}

// ── Modals ─────────────────────────────────────
function openModal(id) {
    const overlay = document.getElementById(id);
    if (overlay) {
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const overlay = document.getElementById(id);
    if (overlay) {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }
}

// Close modal on overlay click
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('open');
        document.body.style.overflow = '';
    }
});

// Close on Escape
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.open').forEach(function (m) {
            m.classList.remove('open');
            document.body.style.overflow = '';
        });
    }
});

// ── Delivery Area Price Lookup ──────────────────
function initDeliveryAreaSelect() {
    const select = document.getElementById('delivery_area_id');
    const priceDisplay = document.getElementById('delivery-price-display');
    const priceInput = document.getElementById('delivery_price_value');

    if (!select) return;

    select.addEventListener('change', function () {
        const price = this.options[this.selectedIndex].dataset.price || '0';
        if (priceDisplay) priceDisplay.textContent = parseFloat(price).toFixed(2);
        if (priceInput) priceInput.value = price;
        updateTotal();
    });
}

function updateTotal() {
    const price    = parseFloat(document.getElementById('price_input')?.value || 0);
    const delivery = parseFloat(document.getElementById('delivery_area_id')?.options[
        document.getElementById('delivery_area_id')?.selectedIndex
    ]?.dataset?.price || 0);
    const taxPct   = parseFloat(document.getElementById('tax_pct')?.value || 0);
    const subtotal = price + delivery;
    const total    = subtotal + (subtotal * taxPct / 100);
    const el = document.getElementById('total-display');
    if (el) el.textContent = total.toFixed(2);
}

// ── View Toggle (card / list) ──────────────────
function initViewToggle() {
    const saved = getCookie('wein_view') || 'card';
    applyView(saved);

    document.querySelectorAll('.view-toggle button').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const mode = this.dataset.view;
            applyView(mode);
            document.cookie = 'wein_view=' + mode + ';path=/;max-age=' + (365 * 24 * 3600);
        });
    });
}

function applyView(mode) {
    const container = document.getElementById('products-container');
    if (!container) return;
    container.className = mode === 'list' ? 'products-list' : 'products-grid';
    document.querySelectorAll('.view-toggle button').forEach(function (btn) {
        btn.classList.toggle('active', btn.dataset.view === mode);
    });
}

// ── Flash message auto-dismiss ──────────────────
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        document.querySelectorAll('.alert-dismissible').forEach(function (el) {
            el.style.opacity = '0';
            el.style.transition = 'opacity .5s';
            setTimeout(function () { el.remove(); }, 500);
        });
    }, 4000);

    initDeliveryAreaSelect();
    initViewToggle();

    // Update price on input
    const priceInput = document.getElementById('price_input');
    if (priceInput) priceInput.addEventListener('input', updateTotal);
});

// ── Mobile Sidebar Toggle ───────────────────────
function toggleSidebar() {
    document.querySelector('.sidebar')?.classList.toggle('open');
}

// ── Confirm Delete ──────────────────────────────
function confirmDelete(formId, message) {
    const msg = message || 'Are you sure you want to delete this item?';
    if (confirm(msg)) {
        document.getElementById(formId)?.submit();
    }
}
