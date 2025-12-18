<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProdukModel;
use CodeIgniter\API\ResponseTrait;

class Produk extends BaseController
{
    use ResponseTrait;
    
    protected $model;
    
    public function __construct()
    {
        $this->model = new ProdukModel();
        helper('form');
    }
    
    // GET: /api/produk - Menampilkan semua produk
    public function index()
    {
        $data = $this->model->findAll();
        return $this->respond([
            'status' => 'success',
            'data' => $data
        ]);
    }
    
    // GET: /api/produk/{id} - Menampilkan produk berdasarkan ID
    public function show($id = null)
    {
        $data = $this->model->find($id);
        
        if (!$data) {
            return $this->failNotFound('Produk tidak ditemukan');
        }
        
        return $this->respond([
            'status' => 'success',
            'data' => $data
        ]);
    }
    
    // POST: /api/produk - Menambah produk baru
    public function create()
    {
        // Ambil data dari JSON body
        $data = $this->request->getJSON(true);
        
        // Cek apakah data valid
        if (empty($data)) {
            return $this->failValidationErrors([
                'error' => 'Data tidak valid. Pastikan mengirim JSON dengan Content-Type: application/json'
            ]);
        }
        
        // Validasi input
        if (!$this->validateRequest($data)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        
        // Simpan data
        $insertId = $this->model->insert($data);
        
        if ($insertId) {
            $data['id'] = $insertId;
            return $this->respondCreated([
                'status' => 'success',
                'message' => 'Produk berhasil ditambahkan',
                'data' => $data
            ]);
        }
        
        return $this->failServerError('Gagal menambahkan produk');
    }
    
    // PUT: /api/produk/{id} - Mengupdate produk
    public function update($id = null)
    {
        // Ambil data dari JSON body
        $data = $this->request->getJSON(true);
        
        // Cek apakah data valid
        if (empty($data)) {
            return $this->failValidationErrors([
                'error' => 'Data tidak valid. Pastikan mengirim JSON dengan Content-Type: application/json'
            ]);
        }
        
        // Cek apakah produk ada
        if (!$this->model->find($id)) {
            return $this->failNotFound('Produk tidak ditemukan');
        }
        
        // Validasi input
        if (!$this->validateRequest($data, $id)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        
        // Update data
        if ($this->model->update($id, $data)) {
            $data['id'] = $id;
            return $this->respond([
                'status' => 'success',
                'message' => 'Produk berhasil diupdate',
                'data' => $data
            ]);
        }
        
        return $this->failServerError('Gagal mengupdate produk');
    }
    
    // DELETE: /api/produk/{id} - Menghapus produk
    public function delete($id = null)
    {
        // Cek apakah produk ada
        if (!$this->model->find($id)) {
            return $this->failNotFound('Produk tidak ditemukan');
        }
        
        // Hapus data
        if ($this->model->delete($id)) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus'
            ]);
        }
        
        return $this->failServerError('Gagal menghapus produk');
    }
    
    // Validasi request
    private function validateRequest($data, $id = null)
    {
        // Pastikan data adalah array
        if (!is_array($data)) {
            $data = [];
        }
        
        $validationRules = [
            'nama' => 'required|min_length[3]',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ];
        
        return $this->validateData($data, $validationRules);
    }
}