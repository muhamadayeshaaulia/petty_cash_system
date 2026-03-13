<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
}
