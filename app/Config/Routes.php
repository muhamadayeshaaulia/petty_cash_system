<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute untuk Login dan Logout
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('auth/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');

// Rute Dashboard Sementara (Agar tidak error setelah login)
$routes->get('karyawan/dashboard', function() {
    return 'Selamat datang KARYAWAN: <b>' . session()->get('nama_lengkap') . '</b> | <a href="/logout">Logout</a>';
});
$routes->get('admin/dashboard', function() {
    return 'Selamat datang ADMIN KEUANGAN: <b>' . session()->get('nama_lengkap') . '</b> | <a href="/logout">Logout</a>';
});
$routes->get('manajer/dashboard', function() {
    return 'Selamat datang MANAJER KEUANGAN: <b>' . session()->get('nama_lengkap') . '</b> | <a href="/logout">Logout</a>';
});