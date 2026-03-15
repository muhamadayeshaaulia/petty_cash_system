<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Database\Migrations\CreateSaldoTable;
use App\Database\Migrations\CreatePengajuanTable;
use App\Models\PengajuanSaldoModel;
use App\Models\SaldoModel;

class AdminController extends BaseController
{
    protected $pengajuanModel;
    protected $saldoModel;
    protected $pengajuanSaldoModel;

    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel();
        $this->saldoModel= new SaldoModel();
        $this->pengajuanSaldoModel= new PengajuanSaldoModel();
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
                              ->select('pengajuan.*, pegawai.nama_lengkap')
                              ->join('pegawai', 'pegawai.id_pegawai = pengajuan.id_pegawai')
                              ->orderBy('pengajuan.tanggal_pengajuan', 'DESC')
                              ->findAll();

        // mengambil total saldo saat ini
        $saldoRow = $this->saldoModel->first();
        $total_saldo = $saldoRow ? $saldoRow['total_saldo'] : 0;

        //Hitung Sisa Kuota Top-Up Bulan Ini (Maks 25 Juta)
        $bulan_ini = date('m');
        $tahun_ini = date('Y');
        $builder = $this->pengajuanSaldoModel->builder();
        $builder->selectSum('nominal');
        $builder->where('MONTH(tanggal_pengajuan)', $bulan_ini);
        $builder->where('YEAR(tanggal_pengajuan)', $tahun_ini);
        $builder->whereIn('status', ['pending', 'disetujui']);
        $query = $builder->get()->getRow();
        
        $total_terpakai = $query->nominal ?? 0;
        $sisa_kuota = 25000000 - $total_terpakai;

        $data = [
            'title'       => 'Dashboard Admin Keuangan',
            'pengajuan'   => $dataPengajuan,
            'total_saldo' => $total_saldo,
            'sisa_kuota'  => $sisa_kuota
        ];

        return view('admin/dashboard', $data);
    }

    // Fungsi untuk memproses aksi Terima/Tolak dari Admin
   public function teruskanKeManager($id_pengajuan)
    {
        if (session()->get('role') !== 'admin_keuangan') return redirect()->to('/login');

        // Ubah status dari 'pending' menjadi 'diperiksa'
        $this->pengajuanModel->update($id_pengajuan, ['status' => 'diperiksa']);
        
        session()->setFlashdata('success', 'Pengajuan berhasil diteruskan ke Manager untuk di-ACC.');
        return redirect()->to('/admin/dashboard');
    }

    // FUNGSI Admin mencairkan dana (Setelah di-ACC Manager)
    public function cairkanDana($id_pengajuan)
    {
        if (session()->get('role') !== 'admin_keuangan') return redirect()->to('/login');

        // Ambil data pengajuan yang mau dicairkan
        $pengajuan = $this->pengajuanModel->find($id_pengajuan);

        if ($pengajuan && $pengajuan['status'] == 'disetujui') {
            
            // Ambil total saldo Petty Cash saat ini
            $saldoRow = $this->saldoModel->first();
            $saldo_sekarang = $saldoRow['total_saldo'];

            // CEK SALDO: Apakah cukup untuk mencairkan?
            if ($saldo_sekarang < $pengajuan['nominal']) {
                session()->setFlashdata('error', 'Gagal! Saldo Anda tidak cukup (Sisa: Rp ' . number_format($saldo_sekarang, 0, ',', '.') . '). Silakan ajukan Top-Up ke Manager.');
                return redirect()->to('/admin/dashboard');
            }

            // POTONG SALDO: Kurangi saldo dengan nominal pencairan
            $saldo_baru = $saldo_sekarang - $pengajuan['nominal'];
            $this->saldoModel->update($saldoRow['id_saldo'], ['total_saldo' => $saldo_baru]);

            // UBAH STATUS PENGAJUAN: Menjadi 'dicairkan'
            $this->pengajuanModel->update($id_pengajuan, ['status' => 'dicairkan']);

            session()->setFlashdata('success', 'Dana sebesar Rp ' . number_format($pengajuan['nominal'], 0, ',', '.') . ' berhasil dicairkan! Saldo Petty Cash telah dipotong otomatis.');
        } else {
            session()->setFlashdata('error', 'Data tidak valid atau belum di-ACC Manager.');
        }
        
        return redirect()->to('/admin/dashboard');
    }

    // fungsi untuk pengajuan top up saldo
    public function ajukanTopup()
    {
        if (session()->get('role') !== 'admin_keuangan') return redirect()->to('/login');

        $nominal_request = $this->request->getPost('nominal');
        $id_pegawai = session()->get('id_pegawai');
        
        $bulan_ini = date('m');
        $tahun_ini = date('Y');

        // HITUNG BERAPA YANG SUDAH DIAJUKAN BULAN INI
        // Kita hitung yang statusnya 'pending' dan 'disetujui' (yang ditolak tidak dihitung)
        $builder = $this->pengajuanSaldoModel->builder();
        $builder->selectSum('nominal');
        $builder->where('MONTH(tanggal_pengajuan)', $bulan_ini);
        $builder->where('YEAR(tanggal_pengajuan)', $tahun_ini);
        $builder->whereIn('status', ['pending', 'disetujui']);
        $query = $builder->get()->getRow();

        $total_terpakai_bulan_ini = $query->nominal ?? 0;
        
        // CEK SISA KUOTA (Maksimal 25 Juta)
        $limit_bulanan = 25000000;
        $sisa_kuota = $limit_bulanan - $total_terpakai_bulan_ini;

        // JIKA NOMINAL YANG DIMINTA MELEBIHI SISA KUOTA, TOLAK!
        if ($nominal_request > $sisa_kuota) {
            session()->setFlashdata('error', 'Pengajuan gagal! Sisa kuota Top-Up Anda bulan ini hanya Rp ' . number_format($sisa_kuota, 0, ',', '.'));
            return redirect()->to('/admin/dashboard');
        }

        // JIKA AMAN, SIMPAN PENGAJUAN KE DATABASE
        $this->pengajuanSaldoModel->save([
            'id_pegawai'        => $id_pegawai,
            'tanggal_pengajuan' => date('Y-m-d'),
            'nominal'           => $nominal_request,
            'status'            => 'pending' // Menunggu ACC Manager
        ]);

        session()->setFlashdata('success', 'Pengajuan Top Up berhasil dikirim ke Manager. Menunggu persetujuan.');
        return redirect()->to('/admin/dashboard');
    }
}