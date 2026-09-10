<?php

namespace App\Http\Controllers;

class InfoController extends Controller
{
    public function lokasi()
    {
        return view('info.lokasi');
    }

    public function tentang()
    {
        return view('info.tentang');
    }
}
