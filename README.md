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
```

6. Setelah mengisi keperluan field di migration lakukan
```php
php spark migrate
```
lalu liat perubahan di database.


<div align="center">
  <p>Made with by 716 Production</p>
  <p>© 2026 Petty Cash. All rights reserved.</p>
</div>