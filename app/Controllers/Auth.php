<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        // jika sudah login, langsung mengarahkan ke dashboard masing2
        if (session()->get('logged_in')){
            return $this->redirectBerdasarkanRole(session()->get('role'));
        }
        return view('auth/login');
    }
    public function process()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // cari data user berdasarkan username
        $user = $userModel->where('username', $username)->first();

        if ($user){
            // verifikasi pass (karena di database pass di ekripsi/di hash)
            if (password_verify((string)$password, $user['password'])){
                // menyimpan data user kedalam session
                $ses_data =[
                'id_user' => $user['id_user'],
                'nama_lengkap' => $user['nama_lengkap'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => TRUE
                ];
                session()->set($ses_data);
                return $this->redirectBerdasarkanRole($user['role']);
            } else{
                session()->setFlashdata('error', 'Password Salah');
                return redirect()->to('/login');
            }
        }else {
            session()->setFlashdata('error', 'Username tidak di temukan!');
            return redirect()->to('/login');
            }

    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    // fungsi agar login rapih saat membagi sesi login rolenya
    private function redirectBerdasarkanRole($role)
    {
        if ($role === 'karyawan') {
            return redirect()->to('/karyawan/dashboard');
        } elseif ($role === 'admin_keuangan') {
            return redirect()->to('/admin/dashboard/');
        }elseif ($role === 'manager_keuangan'){
            return redirect()->to('/manager/dashboard/');
        }
    }
}
