<?php

namespace App\Controllers;

use App\Models\BukuModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\IncomingRequest;

class Buku extends BaseController
{
    protected $bukuModel;
    public function __construct()
    {
        $this->BukuModel = new BukuModel();
    }

    public function index()
    {
        // $buku = $this->bukuModel->findAll();

        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->BukuModel->getBuku()
        ];

        // return view('buku/detail', $data);

        // // cara connect db tanpa model
        // $db = \Config\Database::connect();
        // $buku = $db->query("SELECT * FROM buku");
        // // dd($buku);
        // foreach ($buku->getResultArray() as $row) {
        //     d($row);
        // }

        // connect db dengan model
        // $bukuModel = new \App\Models\BukuModel();
        // atau

        // $bukuModel = new BukuModel();
        // $buku = $bukuModel->findAll();
        // $buku = $this->bukuModel->findAll();
        // dd($buku);



        return view('buku/index', $data);
    }

    public function detail($slug)
    {
        // kita bisa mengambil data komik dengan cara berikut
        // $komik = $this->bukuModel->where[['slug=> $slug]]->first();
        // dd($komik);
        // Namun agar lebih rapi akan dibuat method sendiri di dalam model
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->BukuModel->getBuku($slug)
        ];
        // Jika komik tidak ada di tabel
        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul buku' . $slug . 'tidak ditemukan.');
        }
        return view('buku/detail', $data);
        // echo $slug;
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Buku'
        ];
        return view('buku/create', $data);
    }
    public function save()
    {

        // simoan
        $slug = url_title($this->request->getPost('judul'), '-', true);
        $data = [
            'judul' => $this->request->getPost('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getPost('penulis'),
            'penerbit' => $this->request->getPost('penerbit'),
            'sampul' => $this->request->getPost('sampul')
        ];
        $save = $this->bukuModel->add($data);
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
        return redirect()->to('/buku');
    }
}
