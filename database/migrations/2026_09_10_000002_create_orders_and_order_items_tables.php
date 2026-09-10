<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_code')->unique(); // contoh: ARU-20260910-001
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // customer (nullable jika pesanan langsung kasir)
                $table->foreignId('penjual_id')->nullable()->constrained('users')->onDelete('set null'); // kasir/penjual yang memproses
                $table->enum('tipe_pesanan', ['dine_in', 'takeaway', 'delivery'])->default('takeaway');
                $table->enum('status', ['menunggu_konfirmasi', 'diproses', 'siap_diambil', 'selesai', 'dibatalkan'])->default('menunggu_konfirmasi');
                $table->enum('metode_pembayaran', ['cash', 'qris', 'transfer'])->default('cash');
                $table->enum('status_pembayaran', ['unpaid', 'paid'])->default('unpaid');
                $table->integer('subtotal');
                $table->integer('ongkir')->default(0);
                $table->integer('total_harga');
                $table->integer('uang_diterima')->nullable(); // untuk kasir POS
                $table->integer('uang_kembalian')->nullable(); // untuk kasir POS
                $table->string('nama_pemesan');
                $table->string('nomor_kontak')->nullable();
                $table->text('catatan_alamat')->nullable(); // meja / alamat pengiriman
                $table->text('catatan_pesanan')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                $table->string('nama_produk');
                $table->integer('harga_satuan');
                $table->integer('jumlah');
                $table->integer('subtotal');
                $table->string('ukuran')->default('Reguler'); // Reguler, Large
                $table->string('suhu')->default('Es'); // Es, Panas
                $table->string('manis')->default('Normal'); // No, Less, Normal, Extra
                $table->text('catatan_khusus')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
