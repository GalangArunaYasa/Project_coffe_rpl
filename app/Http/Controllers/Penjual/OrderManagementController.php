<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        $pembayaran = $request->get('pembayaran', 'semua');
        $cari = $request->get('cari');

        $query = Order::with(['items.product', 'customer'])->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        if ($pembayaran !== 'semua') {
            $query->where('status_pembayaran', $pembayaran);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('order_code', 'like', '%' . $cari . '%')
                  ->orWhere('nama_pemesan', 'like', '%' . $cari . '%')
                  ->orWhere('nomor_kontak', 'like', '%' . $cari . '%');
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = [
            'semua' => Order::count(),
            'menunggu_konfirmasi' => Order::where('status', 'menunggu_konfirmasi')->count(),
            'diproses' => Order::where('status', 'diproses')->count(),
            'siap_diambil' => Order::where('status', 'siap_diambil')->count(),
            'selesai' => Order::where('status', 'selesai')->count(),
            'dibatalkan' => Order::where('status', 'dibatalkan')->count(),
            'unpaid' => Order::where('status_pembayaran', 'unpaid')->count(),
            'paid' => Order::where('status_pembayaran', 'paid')->count(),
        ];

        return view('penjual.orders.index', compact('orders', 'status', 'pembayaran', 'cari', 'counts'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'customer', 'penjual']);
        return view('penjual.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu_konfirmasi,diproses,siap_diambil,selesai,dibatalkan'
        ]);

        $order->update([
            'status' => $request->status,
            'penjual_id' => Auth::id(),
        ]);

        return back()->with('success', 'Status pesanan ' . $order->order_code . ' berhasil diperbarui menjadi: ' . $order->status_label);
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:paid,unpaid',
            'uang_diterima' => 'nullable|numeric|min:0',
        ]);

        $uangDiterima = $request->uang_diterima ? (int)$request->uang_diterima : $order->uang_diterima;
        $uangKembalian = $order->uang_kembalian;

        if ($request->status_pembayaran === 'paid') {
            if ($uangDiterima && $uangDiterima >= $order->total_harga) {
                $uangKembalian = $uangDiterima - $order->total_harga;
            } elseif (!$uangDiterima) {
                $uangDiterima = $order->total_harga;
                $uangKembalian = 0;
            }
        }

        $order->update([
            'status_pembayaran' => $request->status_pembayaran,
            'uang_diterima' => $uangDiterima,
            'uang_kembalian' => $uangKembalian,
            'penjual_id' => Auth::id(),
        ]);

        $msg = $request->status_pembayaran === 'paid' 
            ? 'Pembayaran pesanan ' . $order->order_code . ' berhasil dikonfirmasi LUNAS.'
            : 'Status pembayaran pesanan ' . $order->order_code . ' diubah menjadi BELUM BAYAR.';

        return back()->with('success', $msg);
    }
}
