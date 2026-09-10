<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@coffe.com'],
            [
                'name' => 'Admin Aruna',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Akun Penjual / Kasir
        User::updateOrCreate(
            ['email' => 'penjual@coffe.com'],
            [
                'name' => 'Barista Kasir',
                'password' => Hash::make('password'),
                'role' => 'penjual',
            ]
        );

        // 3. Akun Customer
        User::updateOrCreate(
            ['email' => 'customer@coffe.com'],
            [
                'name' => 'Budi Pembeli',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // 4. Produk Kopi & Menu
        $products = [
            [
                'nama' => 'Kopi Susu Gula Aren',
                'deskripsi' => 'Perpaduan kopi, susu segar dan gula aren asli.',
                'harga' => 12000,
                'stok' => 25,
                'kategori' => 'signature',
                'tag' => 'Favorit',
                'is_bestseller' => true,
                'is_active' => true,
                'gambar' => 'images/products/kopi-susu-gula-aren.jpg',
            ],
            [
                'nama' => 'Es Kopi Hitam',
                'deskripsi' => 'Kopi hitam segar pilihan biji terbaik.',
                'harga' => 9000,
                'stok' => 30,
                'kategori' => 'kopi',
                'tag' => 'Segar',
                'is_bestseller' => true,
                'is_active' => true,
                'gambar' => 'images/products/es-kopi-hitam.jpg',
            ],
            [
                'nama' => 'Cappuccino',
                'deskripsi' => 'Kopi dengan busa susu lembut dan nikmat.',
                'harga' => 13000,
                'stok' => 20,
                'kategori' => 'kopi',
                'tag' => 'Klasik',
                'is_bestseller' => true,
                'is_active' => true,
                'gambar' => 'images/products/cappuccino.jpg',
            ],
            [
                'nama' => 'Kopi Latte',
                'deskripsi' => 'Kopi latte dengan rasa yang creamy.',
                'harga' => 13000,
                'stok' => 18,
                'kategori' => 'kopi',
                'tag' => 'Creamy',
                'is_bestseller' => true,
                'is_active' => true,
                'gambar' => 'images/products/kopi-latte.jpg',
            ],
            [
                'nama' => 'Caramel Macchiato',
                'deskripsi' => 'Kombinasi vanila, steamed milk, espresso bold, dan sirup karamel gurih berlapis.',
                'harga' => 16000,
                'stok' => 15,
                'kategori' => 'signature',
                'tag' => 'Spesial',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/caramel-macchiato.jpg',
            ],
            [
                'nama' => 'Matcha Fusion Latte',
                'deskripsi' => 'Matcha premium Jepang kualitas tinggi berpadu susu segar dan manis seimbang.',
                'harga' => 15000,
                'stok' => 16,
                'kategori' => 'non-kopi',
                'tag' => 'Favorit',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/matcha-latte.jpg',
            ],
            [
                'nama' => 'Signature Dark Chocolate',
                'deskripsi' => 'Cokelat hitam pekat premium berpadu susu lembut memanjakan lidah.',
                'harga' => 14000,
                'stok' => 20,
                'kategori' => 'non-kopi',
                'tag' => 'Manis',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/dark-chocolate.jpg',
            ],
            [
                'nama' => 'Red Velvet Delight',
                'deskripsi' => 'Minuman lembut red velvet dengan hint aroma kue tart manis gurih.',
                'harga' => 15000,
                'stok' => 14,
                'kategori' => 'non-kopi',
                'tag' => 'Hits',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/matcha-latte.jpg',
            ],
            [
                'nama' => 'Croissant Butter Crispy',
                'deskripsi' => 'Pastry renyah beraroma butter Prancis asli pendamping ngopi.',
                'harga' => 12000,
                'stok' => 10,
                'kategori' => 'snack',
                'tag' => 'Renyah',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/croissant.jpg',
            ],
            [
                'nama' => 'Roti Bakar Cokelat Keju',
                'deskripsi' => 'Roti bakar empuk isi limpahan cokelat pekat dan keju parut melimpah.',
                'harga' => 14000,
                'stok' => 12,
                'kategori' => 'snack',
                'tag' => 'Kenyang',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/croissant.jpg',
            ],
            [
                'nama' => 'French Fries Sea Salt',
                'deskripsi' => 'Kentang goreng gurih renyah dengan taburan garam laut alami.',
                'harga' => 12000,
                'stok' => 15,
                'kategori' => 'snack',
                'tag' => 'Gurih',
                'is_bestseller' => false,
                'is_active' => true,
                'gambar' => 'images/products/french-fries.jpg',
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['nama' => $p['nama']],
                $p
            );
        }
    }
}
