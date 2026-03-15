<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pegawai'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nip'          => ['type' => 'VARCHAR', 'constraint' => '50', 'unique' => true],
            'email'        => ['type' => 'VARCHAR', 'constraint' => '100', 'unique' => true],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => '100'], // memindahkan nama lengkap yang awalnya ada di user jadi ke pegawai
            'role'         => ['type' => 'ENUM', 'constraint' => ['karyawan', 'admin_keuangan', 'manager_keuangan'], 'default' => 'karyawan'],// memindahkan role yg awalnya ada di user ke tabel pegawai
        ]);
        
        $this->forge->addKey('id_pegawai', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai'); // untuk menghapus tabel pegawai dari database 
    }
}
