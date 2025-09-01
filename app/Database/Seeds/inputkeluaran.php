<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class inputkeluaran extends Seeder
{
    public function run()
    {
        // Sample data for kas_masjid table
        $data = [
            [
                'tgl_km' => '2023-01-01',
                'uraian_km' => 'Pemasukan Pertama',
                'masuk' => 500000,
                'keluar' => 0,
                'jenis' => 'Masuk',
            ],
            [
                'tgl_km' => '2023-01-02',
                'uraian_km' => 'Pengeluaran Pertama',
                'masuk' => 0,
                'keluar' => 200000,
                'jenis' => 'Keluar',
            ],
            [
                'tgl_km' => '2023-01-03',
                'uraian_km' => 'Pemasukan Kedua',
                'masuk' => 300000,
                'keluar' => 0,
                'jenis' => 'Masuk',
            ],
        ];

        // Insert data into kas_masjid table
        $this->db->table('Inputkeluaran')->insertBatch($data);
    }
}
