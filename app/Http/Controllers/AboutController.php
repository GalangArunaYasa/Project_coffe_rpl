<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Menampilkan halaman Tentang Kami.
     */
    public function index()
    {
        $teamMembers = [
            [
                'number'        => '01',
                'name'          => 'Galang Aruna Yasa',
                'role'          => 'Project Manager',
                'description'   => 'Mengatur pembagian tugas, timeline, dan memastikan seluruh proses proyek berjalan dengan baik.',
                'image'         => 'image/about/team-1.jpg',
                'instagram'     => '@andika.p',
                'instagram_url' => 'https://instagram.com/andika.p',
                'github'        => '@andikap',
                'github_url'    => 'https://github.com/andikap',
            ],
            [
                'number'        => '02',
                'name'          => 'Kelvin Allvino Azza',
                'role'          => 'UI/UX Designer',
                'description'   => 'Merancang tampilan website, layout, typography, warna, dan pengalaman pengguna.',
                'image'         => 'image/about/team-2.jpg',
                'instagram'     => '@bimar.mdhn',
                'instagram_url' => 'https://instagram.com/bimar.mdhn',
                'github'        => '@bimarcode',
                'github_url'    => 'https://github.com/bimarcode',
            ],
            [
                'number'        => '03',
                'name'          => 'Yoga Arya Pratama',
                'role'          => 'Frontend Developer',
                'description'   => 'Mengembangkan tampilan website menggunakan HTML, CSS, JavaScript, dan memastikan website responsive.',
                'image'         => 'image/about/team-3.jpg',
                'instagram'     => '@rizky.maul',
                'instagram_url' => 'https://instagram.com/rizky.maul',
                'github'        => '@rizkydev',
                'github_url'    => 'https://github.com/rizkydev',
            ],
            [
                'number'        => '04',
                'name'          => 'Asih Agustina',
                'role'          => 'Backend Developer',
                'description'   => 'Mengembangkan sistem backend, database, autentikasi, dan fungsi utama website.',
                'image'         => 'image/about/team-4.jpg',
                'instagram'     => '@fahmihdy',
                'instagram_url' => 'https://instagram.com/fahmihdy',
                'github'        => '@fahmicode',
                'github_url'    => 'https://github.com/fahmicode',
            ],
            [
                'number'        => '05',
                'name'          => 'Nabila Herviati',
                'role'          => 'Content & Documentation',
                'description'   => 'Menyiapkan konten, dokumentasi proyek, serta membantu kebutuhan informasi dan presentasi website.',
                'image'         => 'image/about/team-5.jpg',
                'instagram'     => '@dimas.alfarizi',
                'instagram_url' => 'https://instagram.com/dimas.alfarizi',
                'github'        => '@dimscode',
                'github_url'    => 'https://github.com/dimscode',
            ],
        ];

        return view('about.index', compact('teamMembers'));
    }
}
