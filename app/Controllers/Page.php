<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Page extends BaseController
{
    public function about()
    {
        return view('public/about', [
            'title'   => 'Tentang Saya',
            'content' => 'Halo! Saya adalah seorang web developer.'
        ]);
    }

    public function artikel($slug)
    {
        $modelArtikel = new ArtikelModel();

        $artikel = $modelArtikel
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->where('artikel.slug', $slug)
            ->first();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];

        return view('public/artikel', compact('artikel', 'title'));
    }

    public function contact()
    {
        return view('public/contact', [
            'title'   => 'Hubungi Saya',
            'content' => 'instagram: luthfi_amr.'
        ]);
    }
}
