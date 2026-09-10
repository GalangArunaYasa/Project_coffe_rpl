<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Menampilkan halaman Lokasi Kami.
     */
    public function index()
    {
        $locations = [
            [
                'id'            => 1,
                'name'          => 'Kopi Gerobakan – Metro Pusat',
                'address'       => 'Jl. AH Nasution, Metro',
                'hours'         => '08.00 – 22.00',
                'status'        => 'Buka',
                'status_detail' => 'Buka sekarang',
                'is_main'       => true,
                'pin_top'       => '34%',
                'pin_left'      => '58%',
                'route_url'     => 'https://maps.google.com/?q=Jl.+AH+Nasution+Metro',
                'latitude'      => -5.1137,
                'longitude'     => 105.3069,
            ],
            [
                'id'            => 2,
                'name'          => 'Kopi Gerobakan – Metro Timur',
                'address'       => 'Jl. Ki Hajar Dewantara',
                'hours'         => '09.00 – 21.00',
                'status'        => 'Buka',
                'status_detail' => 'Buka sekarang',
                'is_main'       => false,
                'pin_top'       => '44%',
                'pin_left'      => '34%',
                'route_url'     => 'https://maps.google.com/?q=Jl.+Ki+Hajar+Dewantara+Metro',
                'latitude'      => -5.1189,
                'longitude'     => 105.3150,
            ],
        ];

        // Titik-titik marker tambahan di peta untuk estetika visual peta
        $extraPins = [
            [
                'pin_top'  => '22%',
                'pin_left' => '76%',
                'name'     => 'Gerobak Kopi Tejosari',
            ],
        ];

        $infoFeatures = [
            [
                'icon'     => 'bi-geo-alt-fill',
                'title'    => 'Lokasi Strategis',
                'desc'     => 'Mudah ditemukan dan dekat dengan pelanggan',
            ],
            [
                'icon'     => 'bi-clock-fill',
                'title'    => 'Jam Operasional',
                'desc'     => 'Setiap hari<br>08.00 – 22.00',
            ],
            [
                'icon'     => 'bi-scooter',
                'title'    => 'Pesan & Antar',
                'desc'     => 'Pesan kopi dari lokasi terdekat',
            ],
        ];

        return view('location.index', compact('locations', 'extraPins', 'infoFeatures'));
    }
}
