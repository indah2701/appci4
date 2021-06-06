<?php

namespace App\Controllers;

use App\Models\BukuModel;


class Buku extends BaseController
{
    protected $bukuModel;
    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        // $buku = $this->bukuModel->findAll();

        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->bukuModel->getBuku()
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
        // kita bisa mengambil data buku dengan cara berikut
        // $buku= $this->bukuModel->where[['slug=> $slug]]->first();
        // dd($buku);
        // Namun agar lebih rapi akan dibuat method sendiri di dalam model
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->bukuModel->getBuku($slug)
        ];
        // // Jika buku tidak ada di tabel
        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul buku' . $slug . 'tidak ditemukan.');
        }
        return view('buku/detail', $data);
        // echo $slug;
    }

    public function tambah()
    {
        // session();
        $data = [
            'title' => 'Form Tambah Data Buku',
            'validation' => \Config\Services::validation()
        ];
        return view('buku/create', $data);
    }
    public function save()
    {

        // Validasi input
        if (!$this->validate([
            'judul' => [
                'rules'  => 'required|is_unique[buku.judul]',
                'errors' => [
                    'required'  => '{field} buku harus diisi.',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules'  => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in'  => 'Yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // dd($validation);
            // return redirect()->to('/buku/create')->withInput()->with('validation', $validation);
            return redirect()->to('/buku/create')->withInput();
        }


        // ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        // Apakah tidak ada gambar yang diuploud
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.jpg';
        } else {
            //generate nama sampul random
            $namaSampul = $fileSampul->getRandomName();
            // Pindahkan file ke folder
            $fileSampul->move('img', $namaSampul);
        }
        // // pindahkan file ke folder img
        // $fileSampul->move('img');
        // // ambil nama file
        // $namaSampul = $fileSampul->getName();

        // simpan
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->bukuModel->save([
            'judul'     => $this->request->getVar('judul'),
            'slug'      => $slug,
            'penulis'   => $this->request->getVar('penulis'),
            'penerbit'  => $this->request->getVar('penerbit'),
            'sampul'    => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data Berhasil disimpan');
        return redirect()->to('/buku');
    }

    public function hapus($id)
    {
        // cari gambar berdasarkan id
        $buku = $this->bukuModel->find($id);
        // cek jika gambarnya default.jpg
        if ($buku['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $buku['sampul']);
        }

        $this->bukuModel->delete($id);
        session()->setFlashdata('hapus', 'Data Berhasil Dihapus');
        return redirect()->to('/buku');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Buku',
            'buku' => $this->bukuModel->getBuku($slug),
            'validation' => \Config\Services::validation()
        ];
        return view('buku/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $bukuLama = $this->bukuModel->getBuku($this->request->getVar('slug'));
        if ($bukuLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[buku.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} buku harus diisi.',
                    'is_unique' => '{field} buku sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Pilih gambar sampul terlebih dahulu',
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang Anda pilih bukan gambar',
                    'mime_in' => 'Yang Anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // dd($validation);
            return redirect()->to('/buku/edit/' . $this->request->getVar('slug'))->withInput();
        }
        $fileSampul = $this->request->getFile('sampul');

        // Cek gambar, apakah tetap gambar lama
        if (
            $fileSampul->getError() == 4
        ) {
            $namaSampul = $this->request->getvar('sampulLama');
        } else if ($this->request->getVar('sampulLama') == 'default.jpg') {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaSampul);
        } else {

            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar
            $fileSampul->move('img', $namaSampul);
            // hapus file sampul lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }


        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->bukuModel->save([
            'id'       => $id,
            'judul'    => $this->request->getVar('judul'),
            'slug'     => $slug,
            'penulis'  => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul'   => $namaSampul
        ]);
        session()->setFlashdata('pesan', 'Data Berhasil Diubah');
        return redirect()->to('/buku');
    }
}
