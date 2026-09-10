<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderMonitoringController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $tipe = $request->get('tipe', 'semua');
        $pembayaran = $request->get('pembayaran', 'semua');
        $cari = $request->get('cari');

        $query = Order::with(['items.product', 'customer', 'penjual'])->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        if ($tipe !== 'semua') {
            $query->where('tipe_pesanan', $tipe);
        }

        if ($pembayaran !== 'semua') {
            $query->where('status_pembayaran', $pembayaran);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('order_code', 'like', '%' . $cari . '%')
                  ->orWhere('nama_pemesan', 'like', '%' . $cari . '%');
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $totalOmset = Order::where('status_pembayaran', 'paid')->sum('total_harga');
        $totalTransaksi = Order::count();
        $transaksiSelesai = Order::where('status', 'selesai')->count();
        $transaksiPending = Order::where('status', 'menunggu_konfirmasi')->count();
        $transaksiUnpaid = Order::where('status_pembayaran', 'unpaid')->count();

        return view('admin.orders.index', compact(
            'orders',
            'status',
            'tipe',
            'pembayaran',
            'cari',
            'totalOmset',
            'totalTransaksi',
            'transaksiSelesai',
            'transaksiPending',
            'transaksiUnpaid'
        ));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'customer', 'penjual']);
        return view('admin.orders.show', compact('order'));
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:paid,unpaid'
        ]);

        $order->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return back()->with('success', 'Status pembayaran pesanan ' . $order->order_code . ' berhasil diubah menjadi: ' . strtoupper($request->status_pembayaran));
    }
}
