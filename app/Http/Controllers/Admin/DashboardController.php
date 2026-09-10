<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\RestockRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalBestseller = Product::where('is_bestseller', true)->count();
        $stokTipis = Product::where('stok', '<=', 5)->orderBy('stok', 'asc')->get();

        $totalOmset = Order::where('status_pembayaran', 'paid')->sum('total_harga');
        $totalPesananSelesai = Order::where('status', 'selesai')->count();
        $pesananMenunggu = Order::where('status', 'menunggu_konfirmasi')->count();

        $permintaanRestokPending = RestockRequest::with(['product', 'penjual'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        $transaksiTerbaru = Order::with(['items.product', 'customer', 'penjual'])
            ->latest()
            ->take(6)
            ->get();

        // Top 5 Produk Terlaris berdasarkan order items
        $topProducts = OrderItem::select('product_id', 'nama_produk', DB::raw('SUM(jumlah) as total_terjual'), DB::raw('SUM(subtotal) as total_omset'))
            ->groupBy('product_id', 'nama_produk')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalBestseller',
            'stokTipis',
            'totalOmset',
            'totalPesananSelesai',
            'pesananMenunggu',
            'permintaanRestokPending',
            'transaksiTerbaru',
            'topProducts'
        ));
    }
}
