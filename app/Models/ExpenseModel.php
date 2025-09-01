<?php
// File: Models/ExpenseModel.php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseModel extends Model
{
    protected $table = 'inputkeluaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tgl_km', 'uraian_km', 'masuk', 'keluar', 'jenis'];

    // Other model configurations, if needed...

    public function getKasMasjid()
    {
        return $this->findAll();
    }

    public function getKasMasjidById($id)
    {
        return $this->find($id);
    }
}
