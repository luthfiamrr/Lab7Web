<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;
use App\Models\KategoriModel;

class ArtikelKategori extends Cell
{
    public function render(array $params = []): string
    {
        $model = new KategoriModel();
        $kategoriList = $model->select('nama_kategori, slug_kategori')->distinct()->findAll();

        return view('components/artikel_kategori', ['kategoriList' => $kategoriList]);
    }
}
