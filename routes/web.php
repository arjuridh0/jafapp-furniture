<?php

use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomOrderPublicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// ─── Halaman Publik ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/lacak-pesanan', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/lacak-pesanan', [TrackingController::class, 'show'])->name('tracking.show');

// ─── Keranjang (Session-based) ──────────────────────────────
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/keranjang/count', [CartController::class, 'count'])->name('cart.count');

// ─── Checkout (Accessible tanpa login — Guest Checkout) ─────
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/check-email', [CheckoutController::class, 'checkEmail'])->name('checkout.check-email');

// ─── Custom Order (Accessible tanpa login) ──────────────────
Route::get('/custom-order', [CustomOrderPublicController::class, 'create'])->name('custom-order.create');
Route::post('/custom-order', [CustomOrderPublicController::class, 'store'])->name('custom-order.store');

// ─── Checkout (Require auth — setelah order dibuat) ─────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout/konfirmasi/{orderNumber}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    Route::get('/checkout/status/{orderNumber}', [CheckoutController::class, 'paymentStatus'])->name('checkout.payment-status');
    Route::post('/checkout/snap-token/{orderNumber}', [CheckoutController::class, 'getSnapToken'])->name('checkout.snap-token');
    Route::post('/checkout/mock-pay/{orderNumber}', [CheckoutController::class, 'mockPay'])->name('checkout.mock-pay');

    // ─── Customer Area ──────────────────────────────────────
    Route::get('/pesanan-saya', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/pesanan-saya/{orderNumber}', [CustomerController::class, 'orderDetail'])->name('customer.orders.show');

    // ─── Customer Custom Order ──────────────────────────────
    Route::get('/custom-order-saya', [CustomerController::class, 'customOrders'])->name('customer.custom-orders');

    // ─── Customer Profile & Password ────────────────────────
    Route::get('/profil', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::put('/profil/password', [CustomerController::class, 'updatePassword'])->name('customer.update-password');
});

// ─── Autentikasi ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    // Forgot Password
    Route::get('/lupa-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ─── Aktivasi Akun ──────────────────────────────────────────
Route::get('/aktivasi/{token}', [ActivationController::class, 'activate'])->name('activation.activate');
Route::get('/aktivasi/set-password/{token}', [ActivationController::class, 'showSetPasswordForm'])->name('activation.set-password');
Route::post('/aktivasi/set-password/{token}', [ActivationController::class, 'setPassword'])->name('activation.set-password.submit');
Route::get('/kirim-ulang-aktivasi', function () { return view('auth.resend-activation'); })->name('activation.resend-form');
Route::post('/kirim-ulang-aktivasi', [ActivationController::class, 'resend'])->name('activation.resend');

// ─── Panel Admin ────────────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:admin,superadmin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Kategori
        Route::resource('categories', Admin\CategoryController::class)->except(['create', 'show', 'edit']);

        // Produk
        Route::resource('products', Admin\ProductController::class)->except(['show', 'destroy']);
        Route::patch('/products/{product}/toggle-active', [Admin\ProductController::class, 'toggleActive'])->name('products.toggle-active');

        // Pesanan
        Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/update-shipping', [Admin\OrderController::class, 'updateShipping'])->name('orders.update-shipping');
        Route::post('/orders/{order}/update-production', [Admin\OrderController::class, 'updateProduction'])->name('orders.update-production');

        // Custom Order
        Route::get('/custom-orders', [Admin\CustomOrderController::class, 'index'])->name('custom-orders.index');
        Route::get('/custom-orders/{customOrder}', [Admin\CustomOrderController::class, 'show'])->name('custom-orders.show');
        Route::post('/custom-orders/{customOrder}/approve', [Admin\CustomOrderController::class, 'approve'])->name('custom-orders.approve');
        Route::post('/custom-orders/{customOrder}/reject', [Admin\CustomOrderController::class, 'reject'])->name('custom-orders.reject');

        // Laporan
        Route::get('/reports/sales', [Admin\ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/sales/pdf', [Admin\ReportController::class, 'exportSalesPdf'])->name('reports.sales.pdf');
        Route::get('/reports/sales/excel', [Admin\ReportController::class, 'exportSalesExcel'])->name('reports.sales.excel');
        Route::get('/reports/production', [Admin\ReportController::class, 'production'])->name('reports.production');
        Route::get('/reports/production/pdf', [Admin\ReportController::class, 'exportProductionPdf'])->name('reports.production.pdf');
        Route::get('/reports/production/excel', [Admin\ReportController::class, 'exportProductionExcel'])->name('reports.production.excel');

        // ─── Super Admin Only ───────────────────────────────
        Route::middleware('role:superadmin')->group(function () {
            Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
            Route::get('/users/create', [Admin\UserController::class, 'create'])->name('users.create');
            Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
            Route::patch('/users/{user}/toggle-active', [Admin\UserController::class, 'toggleActive'])->name('users.toggle-active');
            Route::patch('/users/{user}/role', [Admin\UserController::class, 'updateRole'])->name('users.update-role');
        });
    });
