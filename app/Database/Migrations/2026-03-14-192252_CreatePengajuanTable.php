<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengajuanTable extends Migration
{
   public function up()
    {
        $this->forge->addField([
            'id_pengajuan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pegawai'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_pengajuan' => ['type' => 'DATE'],
            'keterangan'   => ['type' => 'TEXT'],
            'nominal'      => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'status'       => ['type' => 'ENUM', 'constraint' => ['pending', 'diperiksa', 'disetujui', 'ditolak'], 'default' => 'pending'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        
        $this->forge->addKey('id_pengajuan', true);
        // RELASIKAN KE TABEL PEGAWAI
        $this->forge->addForeignKey('id_pegawai', 'pegawai', 'id_pegawai', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan');
    }
    public function down()
    {
        $this->forge->dropTable('pengajuan');
    }
}
