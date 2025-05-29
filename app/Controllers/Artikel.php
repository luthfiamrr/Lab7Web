<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $q = $this->request->getVar('q') ?? '';

        $modelArtikel = new ArtikelModel();

        $artikel = $modelArtikel->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->like('artikel.judul', $q)
            ->paginate(4);

        $data = [
            'title' => $title,
            'q' => $q,
            'artikel' => $artikel,
            'pager' => $modelArtikel->pager,
        ];

        return view('admin/admin_index', $data);
    }


    public function add()
    {
        $kategoriModel = new \App\Models\KategoriModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'kategori' => 'required',
            'kategori_baru' => 'permit_empty',
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $file = $this->request->getFile('gambar');
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/gambar', $newName);

            // Proses kategori
            $kategoriInput = $this->request->getPost('kategori');
            $kategoriBaru = $this->request->getPost('kategori_baru');

            // Jika memilih "Buat Baru" dan mengisi kategori baru
            if ($kategoriInput === 'new' && !empty($kategoriBaru)) {
                $slug = url_title($kategoriBaru, '-', true);
                $id_kategori = $kategoriModel->insert([
                    'nama_kategori' => $kategoriBaru,
                    'slug_kategori' => $slug
                ]);
            } else {
                // Jika memilih kategori yang sudah ada
                $id_kategori = $kategoriInput;
            }

            // Simpan artikel
            $artikelModel = new \App\Models\ArtikelModel();
            $artikelModel->save([
                'judul' => $this->request->getPost('judul'),
                'id_kategori' => $id_kategori,
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'gambar' => $newName,
            ]);

            return redirect()->to('admin');
        }

        $data = [
            'title' => "Tambah Artikel Baru",
            'kategori' => $kategoriModel->findAll(),
            'errors' => $validation->getErrors(),
            'old' => $this->request->getPost()
        ];

        return view('admin/add', $data);
    }

    public function edit($id)
    {
        $artikelModel = new \App\Models\ArtikelModel();
        $kategoriModel = new \App\Models\KategoriModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'kategori' => 'required',
            'kategori_baru' => 'permit_empty'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            // Proses kategori
            $kategoriInput = $this->request->getPost('kategori');
            $kategoriBaru = $this->request->getPost('kategori_baru');

            if ($kategoriInput === 'new' && !empty($kategoriBaru)) {
                $slug = url_title($kategoriBaru, '-', true);
                $id_kategori = $kategoriModel->insert([
                    'nama_kategori' => $kategoriBaru,
                    'slug_kategori' => $slug
                ]);
            } else {
                $id_kategori = $kategoriInput;
            }

            // Siapkan data untuk update
            $data = [
                'judul' => $this->request->getPost('judul'),
                'id_kategori' => $id_kategori,
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'))
            ];

            // Cek jika gambar diunggah
            $gambar = $this->request->getFile('gambar');
            if ($gambar && $gambar->isValid()) {
                $newName = $gambar->getRandomName();
                $gambar->move(ROOTPATH . 'public/uploads/gambar', $newName);
                $data['gambar'] = $newName;
            }

            $artikelModel->update($id, $data);
            return redirect()->to('admin');
        }

        $artikel = $artikelModel->find($id);
        $data = [
            'title' => "Edit Artikel",
            'data' => $artikel,
            'kategori' => $kategoriModel->findAll(),
            'errors' => $validation->getErrors(),
            'old' => $this->request->getPost()
        ];

        return view('admin/edit', $data);
    }

    public function delete($id)
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        // Dapatkan data artikel
        $artikel = $artikelModel->find($id);

        // Hapus artikel
        $artikelModel->delete($id);

        // Cek apakah kategori masih digunakan oleh artikel lain
        $count = $artikelModel->where('id_kategori', $artikel['id_kategori'])->countAllResults();

        // Jika tidak ada artikel lain yang menggunakan kategori ini, hapus kategori
        if ($count == 0) {
            $kategoriModel->delete($artikel['id_kategori']);
        }

        return redirect()->to('admin');
    }
}
