<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'harga', 'deskripsi', 'stok'];
    protected $useTimestamps = true;
    
    // Validation rules
    protected $validationRules = [
        'nama' => 'required|min_length[3]',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric'
    ];
    
    protected $validationMessages = [];
    protected $skipValidation = false;
}