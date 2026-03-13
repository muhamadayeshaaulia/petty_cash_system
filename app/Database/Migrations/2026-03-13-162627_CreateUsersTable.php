<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [ // untuk id_user
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_lengkap' => [ // untuk nama lengkap
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
