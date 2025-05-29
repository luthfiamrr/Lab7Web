<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {

        return view('admin/admin_ajax');
    }

    public function getData()
    {
        $model = new ArtikelModel();
        $q = $this->request->getVar('q') ?? '';

        $data = $model->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->findAll();

        return $this->response->setJSON([
            'data' => $data,
        ]);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $data = $model->delete($id);

        $data = [
            'status' => 'OKE'
        ];

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }
}
