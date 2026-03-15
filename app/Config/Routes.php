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
$routes->group('karyawan', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'KaryawanController::dashboard');
    $routes->get('pengajuan/create', 'KaryawanController::create');
    $routes->post('pengajuan/store', 'KaryawanController::store');
});

// Rute Admin Keuangan
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->post('topup/ajukan', 'AdminController::ajukanTopup');

    $routes->get('pengajuan/teruskan/(:num)', 'AdminController::teruskanKeManager/$1');
    $routes->get('pengajuan/cairkan/(:num)', 'AdminController::cairkanDana/$1');
});

//router manager keuangan
$routes->group('manager', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'ManagerController::dashboard');
    $routes->get('pengajuan/update/(:num)/(:any)', 'ManagerController::updateStatus/$1/$2');

    $routes->get('topup/acc/(:num)', 'ManagerController::accTopup/$1');
    $routes->get('topup/tolak/(:num)', 'ManagerController::tolakTopup/$1');
});