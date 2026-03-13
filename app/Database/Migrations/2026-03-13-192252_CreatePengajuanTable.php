<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengajuanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pengajuan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [ // Untuk tahu siapa karyawan yang mengajukan
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATE',
            ],
            'keterangan' => [ // Keperluan dana untuk apa
                'type'       => 'TEXT',
            ],
            'nominal' => [ // Jumlah uang yang diajukan
                'type'       => 'DECIMAL',
                'constraint' => '15,2', 
            ],
            'status' => [ // INI INTI ALURNYA
                'type'       => 'ENUM',
                'constraint' => ['pending', 'diperiksa', 'disetujui', 'ditolak'],
                'default'    => 'pending',
                // Keterangan Alur:
                // 'pending'   = Baru diajukan karyawan (masuk ke Admin)
                // 'diperiksa' = Sudah di-ACC Admin (masuk ke Manager)
                // 'disetujui' = Sudah di-ACC Manager (Dana cair)
                // 'ditolak'   = Ditolak oleh Admin/Manager
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id_pengajuan', true);// sebagai primary key untuk id pengajuan
        
        // Membuat relasi/Foreign Key ke tabel users
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('pengajuan');
    
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan');
    }
}
