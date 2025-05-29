<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Home extends BaseController
{
    public function index(): string
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('public/home', compact('artikel', 'title'));
    }

    public function kategori($kategoriNama)
    {
        $kategoriModel = new \App\Models\KategoriModel();
        $artikelModel = new \App\Models\ArtikelModel();

        $kategoriData = $kategoriModel->where('nama_kategori', $kategoriNama)->first();

        if ($kategoriData) {
            $idKategori = $kategoriData['id_kategori'];
            $artikel = $artikelModel->where('id_kategori', $idKategori)->findAll();
            $title = 'Kategori: ' . $kategoriData['nama_kategori'];
        } else {
            $artikel = [];
            $title = 'Kategori tidak ditemukan';
        }

        return view('public/home', [
            'artikel' => $artikel,
            'title' => $title
        ]);
    }
}
