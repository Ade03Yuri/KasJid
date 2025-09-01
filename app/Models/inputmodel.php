<?php

namespace App\Models;

use CodeIgniter\Model;

class inputmodel extends Model
{
    
    protected $table      = 'inputkas';
    protected $primaryKey = 'id';

    protected $allowedFields = ['tgl_km', 'uraian_km', 'masuk', 'keluar', 'jenis'];

    protected $useTimestamps = false; // Tidak menggunakan kolom created_at dan updated_at

    // Jika Anda ingin menggunakan kolom timestamps, ubah nilai $useTimestamps menjadi true
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
}
