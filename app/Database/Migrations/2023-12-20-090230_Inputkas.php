<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class inputkas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tgl_km' => [
                'type' => 'DATE',
            ],
            'uraian_km' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'masuk' => [
                'type' => 'INT',
            ],
            'keluar' => [
                'type' => 'INT',
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('inputkas');
    }

    

    public function down()
    {
    
        $this->forge->dropTable('inputkas');
       
    }
}
