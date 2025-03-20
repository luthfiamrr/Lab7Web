<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title'   => 'Tentang Saya',
            'content' => 'Halo! Saya adalah seorang web developer.'
        ]);
    }

    public function artikel($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where('slug', $slug)->first();

        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];

        return view('artikel', compact('artikel', 'title'));
    }

    public function contact()
    {
        return view('contact', [
            'title'   => 'Hubungi Saya',
            'content' => 'instagram: luthfi_amr.'
        ]);
    }
}
