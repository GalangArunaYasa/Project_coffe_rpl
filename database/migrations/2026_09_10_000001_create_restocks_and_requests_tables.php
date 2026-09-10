<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('restock_logs')) {
            Schema::create('restock_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // admin yang merestok
                $table->integer('jumlah');
                $table->integer('stok_sebelumnya');
                $table->integer('stok_sesudahnya');
                $table->string('sumber')->default('admin_manual'); // 'admin_manual' atau 'approval_request'
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('restock_requests')) {
            Schema::create('restock_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->foreignId('penjual_id')->constrained('users')->onDelete('cascade'); // penjual yang minta restok
                $table->integer('jumlah_diminta');
                $table->text('alasan')->nullable();
                $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
                $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null'); // admin yang acc/reject
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('restock_requests');
        Schema::dropIfExists('restock_logs');
    }
};
