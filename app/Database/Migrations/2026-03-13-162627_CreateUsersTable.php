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
            'username' => [ // username di gunakan untuk login
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'password' => [ // password untuk login kedalam aplikasi
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [ // menentukan role sebagai siapa
                'type'       => 'ENUM',
                'constraint' => ['karyawan', 'admin_keuangan', 'manajer_keuangan'],
                'default'    => 'karyawan',
            ],
            'created_at' => [ // time pembuatan pertama kali data di buat
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [ // ketika ada update tanggal selalu berubah mengikuti tanggal perubahan
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_user', true); // menentukan primary key
        $this->forge->createTable('users'); // untuk membuat tabel baru di database
    }

    public function down()
    {

    }
}
