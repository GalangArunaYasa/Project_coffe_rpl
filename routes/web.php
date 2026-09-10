<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackerController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Penjual Controllers
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\Penjual\PosController as PenjualPosController;
use App\Http\Controllers\Penjual\OrderManagementController as PenjualOrderController;
use App\Http\Controllers\Penjual\RestockRequestController as PenjualRestockController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RestockController as AdminRestockController;
use App\Http\Controllers\Admin\OrderMonitoringController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| 1. Frontend / Customer Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/lokasi', [InfoController::class, 'lokasi'])->name('info.lokasi');
Route::get('/tentang', [InfoController::class, 'tentang'])->name('info.tentang');

// Keranjang Belanja (Cart)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add.legacy');
Route::post('/cart/update/{key}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout & Pembayaran
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/payment', function () {
    return redirect()->route('cart.index');
});

// Live Order Tracker & Riwayat
Route::get('/order/{order_code}/track', [OrderTrackerController::class, 'track'])->name('order.track');
Route::get('/order/{order_code}/receipt', [OrderTrackerController::class, 'receipt'])->name('order.receipt');
Route::get('/riwayat', [OrderTrackerController::class, 'history'])->name('order.history');

// Profil Akun Pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| 2. Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. Penjual / Kasir / Seller Routes (Hak Akses: Penjual & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:penjual,admin'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/dashboard', [PenjualDashboardController::class, 'index'])->name('dashboard');
    
    // POS (Point of Sale Kasir Walk-in)
    Route::get('/pos', [PenjualPosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PenjualPosController::class, 'checkout'])->name('pos.checkout');

    // Manajemen Pesanan Masuk
    Route::get('/orders', [PenjualOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [PenjualOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [PenjualOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/payment', [PenjualOrderController::class, 'updatePayment'])->name('orders.updatePayment');

    // Pengajuan Permintaan Restok
    Route::get('/restock', [PenjualRestockController::class, 'index'])->name('restock.index');
    Route::post('/restock', [PenjualRestockController::class, 'store'])->name('restock.store');
});

/*
|--------------------------------------------------------------------------
| 4. Admin Panel Routes (Hak Akses Khusus: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Master Produk & Menu
    Route::post('/products/{product}/toggle-bestseller', [AdminProductController::class, 'toggleBestseller'])->name('products.toggleBestseller');
    Route::post('/products/{product}/quick-restock', [AdminProductController::class, 'quickRestock'])->name('products.quickRestock');
    Route::resource('products', AdminProductController::class);

    // Manajemen Restok & Approval Permintaan Restok
    Route::get('/restocks', [AdminRestockController::class, 'index'])->name('restocks.index');
    Route::post('/restocks', [AdminRestockController::class, 'store'])->name('restocks.store');
    Route::get('/restocks/requests', [AdminRestockController::class, 'requests'])->name('restocks.requests');
    Route::post('/restocks/requests/{restockRequest}/approve', [AdminRestockController::class, 'approveRequest'])->name('restocks.requests.approve');
    Route::post('/restocks/requests/{restockRequest}/reject', [AdminRestockController::class, 'rejectRequest'])->name('restocks.requests.reject');

    // Monitoring Penjualan & Transaksi Global
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/payment', [AdminOrderController::class, 'updatePayment'])->name('orders.updatePayment');

    // Kelola Pengguna & Akun Staf
    Route::resource('users', AdminUserController::class)->except(['create', 'show', 'edit']);
});