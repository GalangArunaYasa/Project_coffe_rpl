<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// --- Frontend Routes (Publik) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/payment', function () {
    return view('payment.index');
});

// --- Auth Routes ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Admin Panel Routes (Hanya Bisa Diakses Admin) ---
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalProduk = \App\Models\Product::count();
        $totalBestseller = \App\Models\Product::where('is_bestseller', true)->count();
        $stokTipis = \App\Models\Product::where('stok', '<=', 5)->get();
        return view('admin.dashboard', compact('totalProduk', 'totalBestseller', 'stokTipis'));
    })->name('dashboard');

    Route::post('/products/{product}/toggle-bestseller', [AdminProductController::class, 'toggleBestseller'])->name('products.toggleBestseller');
    Route::resource('products', AdminProductController::class);
});