## RANCANGAN SISTEM INFORMASI PENGELOLAAN PETTY CASH

## Role Sementara
- karyawan buat mengajukan petty cash
- admin keuangan mengecek pengajuan
- manajer keuangan approv pengajuan

## Langkah : 
1. download dan instal kebutuhan untuk framework - **[Composer V2.0.14](https://getcomposer.org/)** dan localhost yang support **[PHP V8.2.12](https://www.apachefriends.org/download.html)** atau di atasnya.

2. setlah semua terinstal dengan baik, buka CMD lalu buat project CI4 
```php
composer create-project codeigniter4/appstarter petty-cash-system
``` 
dan setelah selesai instal project lakukan 
```php
cd petty-cash-system
```
lalu 
```php
code
``` 
untuk masuk ke visual studio code.

3. konfigurasi Environment(.env)
  - cari file env, lakukan rename menjadi (.env)
  - buka .env lakukan perubahan 

```php
//cari CI_ENVIRONMENT = production ubah ke decelopment
//isi app.baseURL = '' dengan http://localhost:8080/
//hapus Tanda # pada keduanya
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
```
4. Persiapan Database
  - Buka MySQL Anda (bisa lewat XAMPP/phpMyAdmin atau database client lainnya) dan buat database kosong baru dengan nama db_petty_cash.
  - Kembali ke file .env di CodeIgniter, cari bagian database dan sesuaikan konfigurasinya :

```php
//(Catatan: Sesuaikan username dan password jika Kamu menggunakan konfigurasi MySQL yang berbeda).
database.default.hostname = localhost
database.default.database = db_petty_cash
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```
5. Buat Tabel Migration yg di butuhkan 
```php 
php spark make:migration CreateUsersTable
php spark make:migration CreatePengajuanTable
```

6. Setelah mengisi keperluan field di migration lakukan
```php
php spark migrate
```
lalu liat perubahan di database.

7. Membuat Data Dummy, jika data sudah di buat lalu jalan kan

```php
// membuat
php spark make:seeder UserSeeder
//menjalankan
php spark db:seed UserSeeder
```

8. membuat keperluan model 

```php
php spark make:model UserModel
php spark make:model PengajuanModel
```

9. membuat keperluan controler

```php
php spark make:controller Auth
```

10. Membuat Tampilan (View) Login

```php
//buat folder auth di app/Views
// buat file di dalam nya 
login.php
```

11. Mengatur router di app/Config/Routes.php

```php
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
```

12. jalan kan server 

```php
php spark serve
//Lalu buka browser dan akses http://localhost:8080/
```

<div align="center">
  <p>Made with by 716 Production</p>
  <p>© 2026 Petty Cash. All rights reserved.</p>
</div>