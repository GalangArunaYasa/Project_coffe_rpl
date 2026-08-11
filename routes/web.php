<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Middleware\IsAdmin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Frontend Routes (Publik) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/payment', function (Request $request) {
    $product = Product::findOrFail($request->query('product_id'));

    return view('payment.index', compact('product'));
});
// --- Auth Routes ---
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Admin Panel Routes (Hanya Bisa Diakses Admin) ---
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalProduk = Product::count();
        $totalBestseller = Product::where('is_bestseller', true)->count();
        $stokTipis = Product::where('stok', '<=', 5)->get();

        return view('admin.dashboard', compact('totalProduk', 'totalBestseller', 'stokTipis'));
    })->name('dashboard');

    Route::post('/products/{product}/toggle-bestseller', [AdminProductController::class, 'toggleBestseller'])->name('products.toggleBestseller');
    Route::resource('products', AdminProductController::class);
});
