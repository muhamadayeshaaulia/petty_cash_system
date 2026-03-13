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

// Rute Karyawan
$routes->get('karyawan/dashboard', 'KaryawanController::dashboard');
$routes->get('karyawan/pengajuan/create', 'KaryawanController::create');
$routes->post('karyawan/pengajuan/store', 'KaryawanController::store');

// Rute Admin Keuangan
$routes->get('admin/dashboard', 'AdminController::dashboard');
$routes->get('admin/pengajuan/update/(:num)/(:any)', 'AdminController::updateStatus/$1/$2');

//router sementara
$routes->get('manager/dashboard', function() {
    return 'Selamat datang MANAJER KEUANGAN: <b>' . session()->get('nama_lengkap') . '</b> | <a href="/logout">Logout</a>';
});