<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | MA Darul Ulum Paiton',
            'tes' => ['satu', 'dua', 'tiga']

        ];
        return view('pages/home', $data);
    }


    public function about()
    {
        $data = [
            'title' => 'About Me'

        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Contact Us',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jln Pondok Pesantren Mambaul Ulum Sukodadi-Paiton',
                    'kota' => 'Probolinggo'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Desa Kedung Rejoso',
                    'kota' => 'Probolinggo'
                ]
            ]
        ];
        return view('pages/contact', $data);
    }
}
