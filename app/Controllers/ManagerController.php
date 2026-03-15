<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\SaldoModel;
use App\Models\PengajuanSaldoModel;
class ManagerController extends BaseController
{
    protected $pengajuanModel;
    protected $saldoModel;
    protected $pengajuanSaldoModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
        $this->saldoModel = new SaldoModel();
        $this->pengajuanSaldoModel = new PengajuanSaldoModel();
    }

    public function dashboard()
    {
        // memastikan hanya role manager_keuangan yang bisa akses
        if (session()->get('role') !== 'manager_keuangan') {
            return redirect()->to('/login');
        }

        // Ambil semua data pengajuan beserta nama karyawannya
        $db = \Config\Database::connect();
        $dataPengajuan = $db->table('pengajuan')
                            ->select('pengajuan.*, pegawai.nama_lengkap')
                            ->join('pegawai', 'pegawai.id_pegawai = pengajuan.id_pegawai')
                            ->where('pengajuan.status !=', 'pending') // Manager tidak melihat yang masih pending di Admin
                            ->orderBy('pengajuan.tanggal_pengajuan', 'DESC')
                            ->get()->getResultArray();

        $dataTopup = $this->pengajuanSaldoModel
                          ->select('pengajuan_saldo.*, pegawai.nama_lengkap')
                          ->join('pegawai', 'pegawai.id_pegawai = pengajuan_saldo.id_pegawai')
                          ->orderBy('pengajuan_saldo.tanggal_pengajuan', 'DESC')
                          ->findAll();

        $data = [
            'title'     => 'Dashboard Manager Keuangan',
            'pengajuan' => $dataPengajuan,
            'data_topup'  => $dataTopup,
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

    public function accTopup($id_topup)
    {
        if (session()->get('role') !== 'manager_keuangan') return redirect()->to('/login');

        $topup = $this->pengajuanSaldoModel->find($id_topup);

        if ($topup && $topup['status'] == 'pending') {
            // Ubah status top-up menjadi disetujui
            $this->pengajuanSaldoModel->update($id_topup, ['status' => 'disetujui']);

            // Tambahkan nominal ke Saldo Utama
            $saldoRow = $this->saldoModel->first();
            $saldo_baru = $saldoRow['total_saldo'] + $topup['nominal'];
            $this->saldoModel->update($saldoRow['id_saldo'], ['total_saldo' => $saldo_baru]);

            session()->setFlashdata('success', 'Top-Up Saldo berhasil di-ACC! Saldo Admin telah bertambah.');
        }
        return redirect()->to('/manager/dashboard');
    }

    // FUNGSI  Untuk Manager menolak Top-Up
    public function tolakTopup($id_topup)
    {
        if (session()->get('role') !== 'manager_keuangan') return redirect()->to('/login');

        $this->pengajuanSaldoModel->update($id_topup, ['status' => 'ditolak']);
        session()->setFlashdata('error', 'Pengajuan Top-Up telah ditolak.');
        
        return redirect()->to('/manager/dashboard');
    }
}