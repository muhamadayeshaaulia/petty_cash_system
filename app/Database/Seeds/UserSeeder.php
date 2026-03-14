<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run() //data dummy
    {
        //Akun Karyawan
        $this->db->table('users')->insert([
            'username' => 'karyawan testing',
            'password' => password_hash('Karyawan123', PASSWORD_DEFAULT)
        ]);
        $userId1 = $this->db->insertID(); 
        $this->db->table('pegawai')->insert([
            'id_user'      => $userId1,
            'nip'          => 'EMP-1001',
            'email'        => 'karyawan@sariling.co.id', 
            'nama_lengkap' => 'Staff Karyawan',
            'role'         => 'karyawan'
        ]);

        // Akun Admin Keuangan
        $this->db->table('users')->insert([
            'username' => 'admin testing',
            'password' => password_hash('Admin123', PASSWORD_DEFAULT)
        ]);
        $userId2 = $this->db->insertID();
        $this->db->table('pegawai')->insert([
            'id_user'      => $userId2,
            'nip'          => 'ADM-2001',
            'email'        => 'admin@sariling.co.id',
            'nama_lengkap' => 'Admin Petty Cash',
            'role'         => 'admin_keuangan'
        ]);

        //Akun Manager Keuangan
        $this->db->table('users')->insert([
            'username' => 'manager testing',
            'password' => password_hash('Manager123', PASSWORD_DEFAULT)
        ]);
        $userId3 = $this->db->insertID();
        $this->db->table('pegawai')->insert([
            'id_user'      => $userId3,
            'nip'          => 'MGR-3001',
            'email'        => 'manager@sariling.co.id',
            'nama_lengkap' => 'Manager Finance',
            'role'         => 'manager_keuangan'
        ]);

        $this->db->table('saldo')->insert([
            'total_saldo' => 0,
            'updated_at'  => date('Y-m-d H:i:s')
        ]);
    }
}
