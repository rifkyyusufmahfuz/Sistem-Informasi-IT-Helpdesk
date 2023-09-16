<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CetakDokumenController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RedirectController;

//halaman input email untuk reset password
Route::get('/reset_password', [ResetPasswordController::class, 'konfirmasi_email']);

//kirim permintaan reset ke email yang telah diinput
Route::post('/reset_password/kirim_email_reset', [ResetPasswordController::class, 'permintaan_reset_password']);

//mengirim email tautan (link token) untuk reset password ke email yang telah diinput
Route::get('/token_reset_password/{token}', [ResetPasswordController::class, 'halaman_reset_password'])->name('reset.password.get');

Route::post('/halaman_reset_password', [ResetPasswordController::class, 'submit_reset_password']);


Route::group(['middleware' => ['auth', 'checkrole:1,2,3,4']], function () {
    Route::get('/redirect', [RedirectController::class, 'cek']);
});

//  jika user belum login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'dologin']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Registrasi
Route::get('/registrasi', [RegisterController::class, 'index']);
Route::resource('/registrasi/registrasi_akun', RegisterController::class);


// Role
// 1 = superadmin
// 2 = admin
// 3 = manager
// 4 = pegawai

// untuk Superadmin
Route::group(['middleware' => ['auth', 'checkrole:1', 'checkstatus:aktif']], function () {
    Route::get('/superadmin', [SuperadminController::class, 'index']);
    Route::resource('/superadmin/crud', SuperadminController::class);

    // data master user
    Route::get('/superadmin/datauseraktif', [SuperadminController::class, 'halaman_datauser']);
    Route::get('/superadmin/datausernonaktif', [SuperadminController::class, 'halaman_datauser_nonaktif']);
    Route::get('/superadmin/datapegawai', [SuperadminController::class, 'halaman_datapegawai']);
    Route::get('/superadmin/lihatdatauser/{id}', [SuperadminController::class, 'show'])->name('lihat_data_pegawai');
    Route::post('/superadmin/aktivasi_semua_user', [SuperadminController::class, 'aktivasi_semua_user']);

    // data master notifikasi
    Route::get('/superadmin/master_notifikasi', [SuperadminController::class, 'master_notifikasi']);
    Route::get('/superadmin/master_stasiun', [SuperadminController::class, 'master_stasiun']);
    Route::get('/superadmin/master_barang', [SuperadminController::class, 'master_barang']);


    Route::get('/superadmin/transaksi_permintaan_software', [SuperadminController::class, 'transaksi_permintaan_software']);
    Route::get('/superadmin/transaksi_permintaan_hardware', [SuperadminController::class, 'transaksi_permintaan_hardware']);
    Route::get('/superadmin/transaksi_otorisasi', [SuperadminController::class, 'transaksi_otorisasi']);
    Route::get('/superadmin/transaksi_tindaklanjut', [SuperadminController::class, 'transaksi_tindaklanjut']);
    Route::get('/superadmin/transaksi_bast_barang_masuk', [SuperadminController::class, 'transaksi_bast_barang_masuk']);
    Route::get('/superadmin/transaksi_bast_barang_keluar', [SuperadminController::class, 'transaksi_bast_barang_keluar']);

    Route::get('/superadmin/laporan_periodik', [SuperadminController::class, 'transaksi_laporan_permintaan']);
});

Route::get('/getpegawaidata/{nip}', [SuperadminController::class, 'getPegawaiData'])->name('getpegawaidata');
Route::get('/getdatabarang/{kodebarang}', [PegawaiController::class, 'getDataBarang'])->name('getdatabarang');

// untuk Admin
Route::group(['middleware' => ['auth', 'checkrole:2', 'checkstatus:aktif']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::resource('/admin/crud', AdminController::class);
    Route::get('/admin/permintaan_software', [AdminController::class, 'permintaan_software']);
    Route::get('/admin/permintaan_software/tambah_software/{id_permintaan}', [AdminController::class, 'tambah_software']);
    Route::get('/admin/permintaan_software/bast_software/{id_permintaan}', [AdminController::class, 'bast_software']);
    Route::post('/admin/tindak_lanjut_software/{id_permintaan}', [AdminController::class, 'tindak_lanjut_software']);

    Route::get('/admin/permintaan_hardware', [AdminController::class, 'permintaan_hardware']);
    Route::get('/admin/permintaan_hardware/cek_hardware/{id_permintaan}', [AdminController::class, 'cek_hardware']);
    Route::get('/admin/permintaan_hardware/bast_hardware/{id_permintaan}', [AdminController::class, 'bast_hardware']);
    Route::post('/admin/tindak_lanjut_hardware/{id_permintaan}', [AdminController::class, 'tindak_lanjut_hardware']);

    Route::get('/admin/laporan_periodik', [AdminController::class, 'halaman_cetak_laporan_permintaan']);
});

// untuk Manager
Route::group(['middleware' => ['auth', 'checkrole:3', 'checkstatus:aktif']], function () {
    Route::get('/manager', [ManagerController::class, 'index']);
    Route::resource('/manager/crud', ManagerController::class);
    Route::get('/manager/dashboard/data', [ManagerController::class, 'getData']);
    Route::get('/manager/permintaan_software', [ManagerController::class, 'permintaan_software']);
    Route::get('/manager/riwayat_otorisasi', [ManagerController::class, 'riwayat_otorisasi']);

    Route::get('/manager/permintaan_hardware', [ManagerController::class, 'permintaan_hardware']);
    Route::get('/manager/riwayat_validasi', [ManagerController::class, 'riwayat_validasi']);
    Route::get('/manager/laporan_periodik', [ManagerController::class, 'halaman_cetak_laporan_permintaan']);
});

// untuk manager dan admin
Route::group(['middleware' => ['auth', 'checkrole:2,3', 'checkstatus:aktif']], function () {
    Route::get('/halaman_bast_barang_masuk', [AdminController::class, 'halaman_barang_masuk_admin']);
    Route::get('/halaman_bast_barang_keluar', [AdminController::class, 'halaman_barang_keluar_admin']);
});


// untuk pegawai
Route::group(['middleware' => ['auth', 'checkrole:4']], function () {
    Route::get('/pegawai', [PegawaiController::class, 'index']);
    Route::get('/pegawai/permintaan_software', [PegawaiController::class, 'permintaan_software']);
    Route::post('/pegawai/simpan_software', [PegawaiController::class, 'simpan_software']);

    Route::get('/pegawai/permintaan_hardware', [PegawaiController::class, 'permintaan_hardware']);
    Route::post('/pegawai/simpan_hardware', [PegawaiController::class, 'simpan_hardware']);

    Route::get('/pegawai/halaman_bast_barang_diterima', [PegawaiController::class, 'halaman_barang_diterima_pegawai']);
    Route::get('/pegawai/halaman_bast_barang_diserahkan', [PegawaiController::class, 'halaman_barang_diserahkan_pegawai']);
});

//untuk notifikasi
Route::get('/notifications', [NotifikasiController::class, 'index']);
Route::delete('/notifikasi/hapus/{id_notifikasi}', [NotifikasiController::class, 'destroy']);
Route::put('/notifikasi/read/{id_notifikasi}', [NotifikasiController::class, 'tandai_telah_dibaca']);
Route::put('/notifikasi/pegawai/read_all/{id}', [NotifikasiController::class, 'read_all_notif_pegawai']);
Route::put('/notifikasi/admin/read_all/{id_role}', [NotifikasiController::class, 'read_all_notif_admin']);


//untuk cetak dokumen
Route::get('/cetak_bast/barang_masuk/{kode_barang}', [CetakDokumenController::class, 'cetak_bast_barang_masuk']);
Route::get('/cetak_bast/barang_keluar/{kode_barang}', [CetakDokumenController::class, 'cetak_bast_barang_keluar']);
Route::get('/form_instalasi_software/{id}', [CetakDokumenController::class, 'cetak_form_instalasi_software']);
Route::get('/form_pengecekan_hardware/{id}', [CetakDokumenController::class, 'cetak_form_pengecekan_hardware']);

Route::post('/create_laporan_permintaan', [CetakDokumenController::class, 'create_laporan_permintaan']);
Route::get('/form_laporan_permintaan_periodik/{id}', [CetakDokumenController::class, 'cetak_laporan_periodik']);
