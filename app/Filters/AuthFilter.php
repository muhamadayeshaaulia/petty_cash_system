<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // CEK LOGIN: Jika belum login, tendang ke halaman login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ANTI-BACK BUTTON: Paksa browser untuk tidak menyimpan riwayat cache
        // Jadi ketika user klik 'Back' setelah logout, browser dipaksa memuat ulang
        // dan akan tertangkap oleh fungsi before() di atas, lalu ditendang ke login.
        $response->setHeader('Cache-Control', 'no-store, max-age=0, no-cache, must-revalidate');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', '0');
    }
}