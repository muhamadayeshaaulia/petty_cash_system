<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class ManagerController extends BaseController
{
    protected $pengajuanModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
    }

    public function dashboard()
    {
        // memastikan hanya role manager_keuangan yang bisa akses
        if (session()->get('role') !== 'manager_keuangan') {
            return redirect()->to('/login');
        }

        // Ambil semua data pengajuan beserta nama karyawannya
        $dataPengajuan = $this->pengajuanModel
                              ->select('pengajuan.*, users.nama_lengkap')
                              ->join('pegawai', 'pegawai.id_pegawai = pengajuan.id_pegawai')
                              ->orderBy('pengajuan.tanggal_pengajuan', 'DESC')
                              ->findAll();

        $data = [
            'title'     => 'Dashboard Manager Keuangan',
            'pengajuan' => $dataPengajuan
        ];

        return view('manager/dashboard', $data);
    }

    // Fungsi untuk memproses aksi Setujui/Tolak dari Manager
    public function updateStatus($id_pengajuan, $status_baru)
    {
        if (session()->get('role') !== 'manager_keuangan') return redirect()->to('/login');

        // Update status di database (disetujui / ditolak)
        $this->pengajuanModel->update($id_pengajuan, [
            'status' => $status_baru
        ]);

        $pesan = ($status_baru == 'disetujui') ? 'Pengajuan berhasil DISETUJUI. Dana bisa segera dicairkan.' : 'Pengajuan telah DITOLAK.';
        session()->setFlashdata('success', $pesan);
        
        return redirect()->to('/manager/dashboard');
    }
}