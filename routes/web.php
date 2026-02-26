<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TamuController;
use App\Http\Controllers\Admin\SuratController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Kadis\KadisController;

// --- GUEST AREA ---
Route::get('/', [GuestController::class, 'index'])->name('guest.dashboard');
Route::get('/form-tamu', [GuestController::class, 'create'])->name('guest.form');
Route::post('/form-tamu', [GuestController::class, 'store'])->name('guest.store');

// --- LOGIN AREA ---
Route::middleware(['guest:admin'])->group(function () {
    Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
});

// --- ADMIN & KADIS AREA ---
Route::middleware(['admin'])->prefix('admin')->group(function () {
    
    // Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    
    // Route Khusus Kadis
    Route::get('/kadis/dashboard', [KadisController::class, 'dashboardKadis'])->name('kadis.dashboard');
    Route::get('/kadis/laporan', [KadisController::class, 'laporanTamu'])->name('kadis.laporan-tamu');

    // --- MANAJEMEN PEGAWAI ---
    Route::get('/data-pegawai', [UserController::class, 'indexPegawai'])->name('admin.data-pegawai');
    Route::post('/data-pegawai/simpan', [UserController::class, 'simpanPegawai'])->name('admin.data-pegawai.simpan'); 
    Route::delete('/data-pegawai/hapus/{id}', [UserController::class, 'hapusPegawai'])->name('admin.data-pegawai.hapus');

    // --- DATA TAMU & EXPORT ---
    Route::get('/data-tamu', [TamuController::class, 'dataTamu'])->name('admin.data-tamu');
    Route::get('/data-tamu/hari-ini', [TamuController::class, 'dataTamuHariIni'])->name('admin.data-tamu.hari-ini');
    Route::get('/export-excel', [TamuController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/cek-tamu-baru', [TamuController::class, 'cekTamuBaru'])->name('admin.cek-tamu');

    // CRUD Tamu
    Route::get('/edit/{id}', [TamuController::class, 'edit'])->name('admin.edit');
    Route::put('/update/{id}', [TamuController::class, 'update'])->name('admin.update');
    Route::delete('/delete/{id}', [TamuController::class, 'destroy'])->name('admin.delete');

    // --- JADWAL PIMPINAN ---
    Route::get('/jadwal-pimpinan', [JadwalController::class, 'indexJadwal'])->name('admin.jadwal-pimpinan');
    Route::post('/jadwal-pimpinan/simpan', [JadwalController::class, 'simpanJadwal'])->name('admin.jadwal-pimpinan.simpan');
    Route::put('/jadwal-pimpinan/update/{id}', [JadwalController::class, 'updateJadwal'])->name('admin.jadwal-pimpinan.update');
    Route::delete('/jadwal-pimpinan/delete/{id}', [JadwalController::class, 'hapusJadwal'])->name('admin.jadwal-pimpinan.delete');
    Route::get('/jadwal-history', [JadwalController::class, 'historyJadwal'])->name('admin.jadwal-history');
    Route::put('/data-pegawai/update/{id}', [UserController::class, 'updatePegawai'])->name('admin.data-pegawai.update');
// Cari bagian ini di file web.php Anda (biasanya di bawah route kadis lainnya)
Route::get('/riwayat-jadwal', [JadwalController::class, 'history'])->name('kadis.riwayat-jadwal');

    // --- ARSIP SURAT ---
    Route::get('/surat-masuk', [SuratController::class, 'suratMasuk'])->name('admin.surat-masuk');
    Route::get('/surat-keluar', [SuratController::class, 'suratKeluar'])->name('admin.surat-keluar');
    Route::post('/arsip/simpan', [SuratController::class, 'simpanArsip'])->name('admin.arsip.simpan');
    Route::delete('/arsip/hapus/{id}', [SuratController::class, 'hapusArsip'])->name('admin.arsip.hapus');
    Route::get('/arsip/edit/{id}', [SuratController::class, 'editsurat'])->name('admin.arsip.edit');

    // --- SETTINGS & MANAJEMEN USER ---
    Route::get('/settings', [AuthController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/update-password', [AuthController::class, 'updatePassword'])->name('admin.update-password');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::get('/manajemen-user', [UserController::class, 'manajemenUser'])->name('admin.manajemen-user');
    Route::post('/manajemen-user', [UserController::class, 'simpanUser'])->name('admin.manajemen-user.store');
    Route::delete('/manajemen-user/{id}', [UserController::class, 'hapusUser'])->name('admin.manajemen-user.destroy');
});