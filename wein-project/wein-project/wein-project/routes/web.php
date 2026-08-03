<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerOrderController as AdminCustomerOrderController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\InstantOrderController as AdminInstantOrderController;
use App\Http\Controllers\Public\OrderController;
use App\Http\Controllers\Public\CustomerOrderController;
use App\Http\Controllers\Public\InstantOrderController;
use App\Http\Controllers\Public\SettingsController;
// ──────────────────────────────────────────────
// Public Routes
// ──────────────────────────────────────────────
Route::get('/', [OrderController::class, 'index'])->name('home');
Route::get('/customer-orders/{id}/chat-status', [App\Http\Controllers\Public\CustomerOrderController::class, 'getChatStatus'])->name('customer-orders.chat-status');// Settings
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::post('/language', [SettingsController::class, 'language'])->name('language.switch');

// Public orders (view open orders + manage customer orders)
Route::get('/orders/{order}', [OrderController::class, 'show'])
    ->whereNumber('order')
    ->name('orders.show');

// Customer Orders (protected by per-order password)
// 1. إضافة طلب عميل جديد داخل الطلب الرئيسي
Route::post('/orders/{order}/customer-orders', [CustomerOrderController::class, 'store'])
    ->whereNumber('order')
    ->name('customer-orders.store');

// 2. المصادقة وتسجيل الدخول للطلب الفرعي
Route::post('/orders/{order}/customer-orders/authenticate', [CustomerOrderController::class, 'authenticate'])
    ->whereNumber('order')
    ->name('customer-orders.authenticate');

Route::get('/customer-orders/{customerOrder}', [CustomerOrderController::class, 'show'])
    ->whereNumber('customerOrder')
    ->name('customer-orders.show');

Route::put('/customer-orders/{customerOrder}', [CustomerOrderController::class, 'update'])
    ->whereNumber('customerOrder')
    ->name('customer-orders.update');

Route::delete('/customer-orders/{customerOrder}', [CustomerOrderController::class, 'destroy'])
    ->whereNumber('customerOrder')
    ->name('customer-orders.destroy');

// Delivery areas API
Route::get('/delivery-areas', [DeliveryAreaController::class, 'publicIndex'])->name('delivery-areas.public');

// Instant Orders (public)
Route::get('/instant-orders', [InstantOrderController::class, 'index'])->name('instant-orders.index');

Route::post('/instant-orders/{instantOrder}/reserve', [InstantOrderController::class, 'reserve'])
    ->whereNumber('instantOrder')
    ->name('instant-orders.reserve');

Route::post('/reservations/authenticate', [InstantOrderController::class, 'authenticate'])->name('reservations.authenticate');

Route::get('/reservations/{reservation}', [InstantOrderController::class, 'showReservation'])
    ->whereNumber('reservation')
    ->name('reservations.show');

Route::put('/reservations/{reservation}', [InstantOrderController::class, 'updateReservation'])
    ->whereNumber('reservation')
    ->name('reservations.update');

Route::delete('/reservations/{reservation}', [InstantOrderController::class, 'destroyReservation'])
    ->whereNumber('reservation')
    ->name('reservations.destroy');

// ──────────────────────────────────────────────
// Admin Routes
// ──────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {

    // Auth
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Main Orders
        Route::resource('orders', AdminOrderController::class)->whereNumber('order');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->whereNumber('order')
            ->name('orders.status');

        // Customer Orders (Admin)
        Route::get('/customer-orders', [AdminCustomerOrderController::class, 'index'])->name('customer-orders.index');
        
        Route::get('/customer-orders/{customerOrder}', [AdminCustomerOrderController::class, 'show'])
            ->whereNumber('customerOrder')
            ->name('customer-orders.show');

        Route::patch('/customer-orders/{customerOrder}/price', [AdminCustomerOrderController::class, 'updatePrice'])
            ->whereNumber('customerOrder')
            ->name('customer-orders.update-price');
            
        Route::delete('/customer-orders/{customerOrder}', [AdminCustomerOrderController::class, 'destroy'])
            ->whereNumber('customerOrder')
            ->name('customer-orders.destroy');

        // Notifications
        Route::resource('notifications', AdminNotificationController::class)->except(['show']);

        // Delivery Areas
        Route::resource('delivery-areas', DeliveryAreaController::class)->except(['show']);

        // Instant Orders
        Route::resource('instant-orders', AdminInstantOrderController::class)->whereNumber('instantOrder');
        
        Route::get('/instant-orders/{instantOrder}/reservations', [AdminInstantOrderController::class, 'reservations'])
            ->whereNumber('instantOrder')
            ->name('instant-orders.reservations');
            
        Route::delete('/instant-orders/reservations/{reservation}', [AdminInstantOrderController::class, 'destroyReservation'])
            ->whereNumber('reservation')
            ->name('instant-orders.reservations.destroy');
    });
});