<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class inputkas extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tgl_km'    => '2023-01-01',
                'uraian_km' => 'Pemasukan Awal',
                'masuk'     => 1000000,
                'keluar'    => 0,
                'jenis'     => 'Masuk',
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ];

        // Using Query Builder to insert data
        $this->db->table('inputkas')->insertBatch($data);
    }
}
