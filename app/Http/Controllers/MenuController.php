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

        $query = Product::query();

        if ($kategoriAktif !== 'semua') {
            $query->where('kategori', $kategoriAktif);
        }

        if ($cari) {
            $query->where('nama', 'like', '%' . $cari . '%');
        }

        $menusFiltered = $query->latest()->get();

        $kategoriList = [
            ['id' => 'semua',    'label' => 'Semua'],
            ['id' => 'kopi',     'label' => 'Kopi'],
            ['id' => 'non-kopi', 'label' => 'Non Kopi'],
            ['id' => 'signature','label' => 'Signature'],
            ['id' => 'snack',    'label' => 'Snack'],
        ];

        return view('menu.index', compact('menusFiltered', 'kategoriList', 'kategoriAktif'));
    }
}