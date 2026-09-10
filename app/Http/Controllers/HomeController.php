<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil produk yang ditandai Best Seller oleh Admin
        $rekomendasi = Product::active()->where('is_bestseller', true)->latest()->take(6)->get();

        // Jika belum ada yang ditandai Best Seller, ambil produk aktif terbaru
        if ($rekomendasi->isEmpty()) {
            $rekomendasi = Product::active()->latest()->take(6)->get();
        }

        $totalMenu = Product::active()->count();

        return view('home.index', compact('rekomendasi', 'totalMenu'));
    }
}