<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomeModel extends Model
{
    protected $table = 'inputkas';
    protected $primaryKey = 'id';
    // Sesuaikan dengan struktur tabel database Anda
    protected $allowedFields = ['tgl_km', 'uraian_km', 'masuk', 'keluar', 'jenis'];

    protected $useTimestamps = false; // Tidak menggunakan kolom created_at dan updated_at

}
