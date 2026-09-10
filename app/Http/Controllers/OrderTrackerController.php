<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderTrackerController extends Controller
{
    public function track($order_code)
    {
        $order = Order::with(['items.product', 'penjual'])->where('order_code', $order_code)->firstOrFail();
        return view('orders.track', compact('order'));
    }

    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk untuk melihat riwayat pesanan Anda.');
        }

        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    public function receipt($order_code)
    {
        $order = Order::with(['items', 'penjual', 'customer'])->where('order_code', $order_code)->firstOrFail();
        return view('orders.receipt', compact('order'));
    }
}
