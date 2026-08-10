<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil produk yang ditandai Best Seller oleh Admin
        $rekomendasi = Product::where('is_bestseller', true)->latest()->get();

        // Jika belum ada yang ditandai Best Seller, ambil 5 produk terbaru
        if ($rekomendasi->isEmpty()) {
            $rekomendasi = Product::latest()->take(5)->get();
        }

        return view('home.index', compact('rekomendasi'));
    }
}