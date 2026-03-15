<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSaldoTable extends Migration
{
    public function up()
    {
        // TABEL SALDO UTAMA (Hanya akan berisi 1 baris data)
        $this->forge->addField([
            'id_saldo'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'total_saldo' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_saldo', true);
        $this->forge->createTable('saldo');

        // TABEL PENGAJUAN SALDO (Admin minta top-up ke Manager)
        $this->forge->addField([
            'id_topup'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pegawai'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true], // Admin yang mengajukan
            'tanggal_pengajuan' => ['type' => 'DATE'],
            'nominal'           => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'status'            => ['type' => 'ENUM', 'constraint' => ['pending', 'disetujui', 'ditolak'], 'default' => 'pending'],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_topup', true);
        $this->forge->addForeignKey('id_pegawai', 'pegawai', 'id_pegawai', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan_saldo');
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan_saldo');
        $this->forge->dropTable('saldo');
    }
}