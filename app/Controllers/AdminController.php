<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class AdminController extends BaseController
{
    protected $pengajuanModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
    }

    public function dashboard()
    {
        // Pastikan hanya role admin_keuangan yang bisa akses
        if (session()->get('role') !== 'admin_keuangan') {
            return redirect()->to('/login');
        }

        // Ambil semua data pengajuan dan gabungkan (JOIN) dengan tabel users 
        // untuk mendapatkan nama karyawan yang mengajukan
        $dataPengajuan = $this->pengajuanModel
                              ->select('pengajuan.*, users.nama_lengkap')
                              ->join('pegawai', 'pegawai.id_pegawai = pengajuan.id_pegawai')
                              ->orderBy('pengajuan.tanggal_pengajuan', 'DESC')
                              ->findAll();

        $data = [
            'title'     => 'Dashboard Admin Keuangan',
            'pengajuan' => $dataPengajuan
        ];

        return view('admin/dashboard', $data);
    }

    // Fungsi untuk memproses aksi Terima/Tolak dari Admin
    public function updateStatus($id_pengajuan, $status_baru)
    {
        if (session()->get('role') !== 'admin_keuangan') return redirect()->to('/login');

        // Update status di database
        $this->pengajuanModel->update($id_pengajuan, [
            'status' => $status_baru
        ]);

        $pesan = ($status_baru == 'diperiksa') ? 'Pengajuan berhasil diverifikasi dan diteruskan ke Manager.' : 'Pengajuan telah ditolak.';
        session()->setFlashdata('success', $pesan);
        
        return redirect()->to('/admin/dashboard');
    }
}