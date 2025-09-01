<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class inputkeluaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
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
                'default' => 0,
            ],
            'keluar' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'jenis' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('inputkeluaran');
    }

    public function down()
    {
        $this->forge->dropTable('inputkeluaran');
    }
}
