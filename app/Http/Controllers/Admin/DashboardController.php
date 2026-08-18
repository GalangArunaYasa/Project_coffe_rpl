<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();

        $karyawanAktif = Karyawan::where('status', 'aktif')->count();

        $sudahAbsen = 0;

        $belumAbsen = $totalKaryawan - $sudahAbsen;

        // INI YANG PALING PENTING
        $dataKaryawan = Karyawan::latest()->get();

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'karyawanAktif',
            'sudahAbsen',
            'belumAbsen',
            'dataKaryawan'
        ));
    }
}