<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $kategoriAktif = $request->get('kategori', 'semua');
        $cari = $request->get('cari');

        $query = Product::active();

        if ($kategoriAktif !== 'semua') {
            $query->where('kategori', $kategoriAktif);
        }

        if ($cari) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%')
                  ->orWhere('tag', 'like', '%' . $cari . '%');
            });
        }

        $menusFiltered = $query->latest()->get();

        $kategoriList = [
            ['id' => 'semua',     'label' => 'Semua Menu', 'icon' => 'bi-grid-fill'],
            ['id' => 'signature', 'label' => 'Signature',  'icon' => 'bi-stars'],
            ['id' => 'kopi',      'label' => 'Espresso & Kopi', 'icon' => 'bi-cup-hot-fill'],
            ['id' => 'non-kopi',  'label' => 'Non Kopi',   'icon' => 'bi-cup-straw'],
            ['id' => 'snack',     'label' => 'Camilan & Roti', 'icon' => 'bi-egg-fried'],
        ];

        return view('menu.index', compact('menusFiltered', 'kategoriList', 'kategoriAktif', 'cari'));
    }

    public function show($id)
    {
        $product = Product::active()->findOrFail($id);
        
        $relatedProducts = Product::active()
            ->where('id', '!=', $product->id)
            ->where('kategori', $product->kategori)
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = Product::active()
                ->where('id', '!=', $product->id)
                ->take(4)
                ->get();
        }

        return view('menu.show', compact('product', 'relatedProducts'));
    }
}