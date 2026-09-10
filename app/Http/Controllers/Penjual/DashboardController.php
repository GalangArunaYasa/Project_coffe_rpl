<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\RestockRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Statistik Penjual Hari Ini
        $transaksiHariIni = Order::whereDate('created_at', $today)->where('status', '!=', 'dibatalkan')->get();
        $omsetHariIni = $transaksiHariIni->where('status_pembayaran', 'paid')->sum('total_harga');
        $totalTransaksiHariIni = $transaksiHariIni->count();

        // Pesanan yang butuh tindakan segera
        $pesananMenunggu = Order::where('status', 'menunggu_konfirmasi')->count();
        $pesananDiproses = Order::where('status', 'diproses')->count();

        // Antrean pesanan aktif terbaru
        $antreanPesanan = Order::with('items.product')
            ->whereIn('status', ['menunggu_konfirmasi', 'diproses', 'siap_diambil'])
            ->latest()
            ->take(8)
            ->get();

        // Monitoring stok produk
        $stokKritis = Product::where('is_active', true)->where('stok', '<=', 5)->get();
        $totalProdukSiapJual = Product::where('is_active', true)->where('stok', '>', 0)->count();

        // Permintaan restok terakhir
        $permintaanRestok = RestockRequest::with('product')
            ->where('penjual_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        return view('penjual.dashboard', compact(
            'omsetHariIni',
            'totalTransaksiHariIni',
            'pesananMenunggu',
            'pesananDiproses',
            'antreanPesanan',
            'stokKritis',
            'totalProdukSiapJual',
            'permintaanRestok'
        ));
    }
}
