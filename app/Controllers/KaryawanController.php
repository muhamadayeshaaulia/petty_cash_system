<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class KaryawanController extends BaseController
{
    protected $pengajuanModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
    }

    public function dashboard()
    {
        // Pastikan hanya role karyawan yang bisa akses
        if (session()->get('role') !== 'karyawan') {
            return redirect()->to('/login');
        }

        $id_user = session()->get('id_pegawai');

        // Ambil data pengajuan KHUSUS milik pegawai yang sedang login
        $data = [
            'title'     => 'Dashboard Karyawan',
            'pengajuan' => $this->pengajuanModel->where('id_pegawai', $id_user)->findAll() // mencari berdasarkan if pegawai
        ];

        return view('karyawan/dashboard', $data);
    }

    public function create()
    {
        if (session()->get('role') !== 'karyawan') return redirect()->to('/login');

        $data = ['title' => 'Ajukan Petty Cash'];
        return view('karyawan/create', $data);
    }

    public function store()
    {
        if (session()->get('role') !== 'karyawan') return redirect()->to('/login');

        // Simpan data ke database
        $this->pengajuanModel->save([
            'id_pegawai'           => session()->get('id_pegawai'), // Ambil ID dari sesi login
            'tanggal_pengajuan' => $this->request->getPost('tanggal_pengajuan'),
            'keterangan'        => $this->request->getPost('keterangan'),
            'nominal'           => $this->request->getPost('nominal'),
            'status'            => 'pending' // Status awal otomatis pending
        ]);

        session()->setFlashdata('success', 'Pengajuan berhasil dikirim dan menunggu pemeriksaan Admin.');
        return redirect()->to('/karyawan/dashboard');
    }
}