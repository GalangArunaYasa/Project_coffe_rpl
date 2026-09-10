<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id',
        'penjual_id',
        'tipe_pesanan',
        'status',
        'metode_pembayaran',
        'status_pembayaran',
        'subtotal',
        'ongkir',
        'total_harga',
        'uang_diterima',
        'uang_kembalian',
        'nama_pemesan',
        'nomor_kontak',
        'catatan_alamat',
        'catatan_pesanan',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'ongkir' => 'integer',
        'total_harga' => 'integer',
        'uang_diterima' => 'integer',
        'uang_kembalian' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penjual(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penjual_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'diproses' => 'Sedang Diracik Barista',
            'siap_diambil' => match ($this->tipe_pesanan) {
                'takeaway' => 'Siap Diambil di Kasir',
                'dine_in' => 'Siap Diantar ke Meja',
                'delivery' => 'Sedang Diantar ke Alamat',
                default => 'Siap Diambil / Diantar',
            },
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getTipePesananLabelAttribute(): string
    {
        return match ($this->tipe_pesanan) {
            'takeaway' => 'Ambil Sendiri (Take Away)',
            'dine_in' => 'Minum di Tempat (Dine In)',
            'delivery' => 'Pesan Antar (Delivery)',
            default => ucfirst((string)$this->tipe_pesanan),
        };
    }

    public function getStatusPembayaranLabelAttribute(): string
    {
        return match ($this->status_pembayaran) {
            'paid' => 'Lunas',
            'unpaid' => 'Belum Bayar',
            default => ucfirst((string)$this->status_pembayaran),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'menunggu_konfirmasi' => 'bg-warning text-dark',
            'diproses' => 'bg-info text-dark',
            'siap_diambil' => 'bg-primary text-white',
            'selesai' => 'bg-success text-white',
            'dibatalkan' => 'bg-danger text-white',
            default => 'bg-secondary text-white',
        };
    }
}
