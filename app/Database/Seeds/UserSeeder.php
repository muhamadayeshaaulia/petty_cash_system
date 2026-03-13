<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [ //isi data dummy Tabel users
            [
                'nama_lengkap' => 'Staf Testing',
                'username' => 'karyawan testing',
                'password' => password_hash('Karyawan123', PASSWORD_DEFAULT),
                'role' => 'karyawan',
            ],
            [
                'nama_lengkap' => 'Admin Testing',
                'username' => 'admin testing',
                'password' => password_hash('Admin123', PASSWORD_DEFAULT),
                'role' => 'admin_keuangan',
            ],
            [
                'nama_lengkap' => 'Manager Testing',
                'username' => 'manager testing',
                'password' => password_hash('Manager123', PASSWORD_DEFAULT),
                'role' => 'manager_keuangan',
            ],
        ];
        $this->table('users')->insertBatch($data);
    }
}
