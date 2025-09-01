<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Load admin model
        $adminModel = model('AdminModel');

        // Data to be inserted
      
         // Data untuk akun pertama
$dataAkun1 = [
    'username' => 'admin',
    'password' => password_hash('12345678', PASSWORD_DEFAULT),
    'nama_lengkap' => 'ade yuri',
    'email' => 'ade03yuri@gmail.com',
];

// Data untuk akun kedua
$dataAkun2 = [
    'username' => 'admin2',
    'password' => password_hash('987654321', PASSWORD_DEFAULT),
    'nama_lengkap' => 'Magfira',
    'email' => 'ademagyul09@gmail.com',
];

// Load admin model
$adminModel = model('AdminModel');

// Insert data akun pertama
$adminModel->insert($dataAkun1);

// Insert data akun kedua
$adminModel->insert($dataAkun2);

    }
}
