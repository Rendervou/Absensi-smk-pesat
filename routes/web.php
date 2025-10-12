<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\dataguruController;
use App\Http\Controllers\dataJurusanController;
use App\Http\Controllers\datakelasController;
use App\Http\Controllers\datasiswaController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\MonitoringLoginController;
use App\Http\Controllers\NaikKelasController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPresensiController;
use Illuminate\Support\Facades\Route;

// ================================================
// PUBLIC ROUTES
// ================================================
Route::get('/', function () {
    return view('welcome');
});

// ================================================
// SHARED AUTH ROUTES (Admin & User)
// ================================================
Route::middleware(['auth', 'check.activity'])->group(function () {
    // Profile (bisa diakses admin & user)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Monitoring API - Update Activity (dipanggil dari JavaScript semua role)
    Route::post('/admin/monitoring/api/update-activity', [MonitoringLoginController::class, 'updateActivity']);
});

// ================================================
// ADMIN ROUTES
// ================================================
Route::middleware(['auth', 'role:admin', 'check.activity'])->prefix('admin')->group(function() {
    
    // Dashboard & Laporan
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/perkelas', [AdminController::class, 'perKelas'])->name('admin.perKelas');
    Route::get('/perbulan', [AdminController::class, 'perBulan'])->name('admin.perBulan');
    
    // Data Master
    Route::resource('siswa', datasiswaController::class);
    Route::resource('kelas', datakelasController::class);
    Route::resource('guru', dataguruController::class);
    Route::resource('rombel', RombelController::class);
    
    // Jurusan (custom routes)
    Route::get('jurusan', [dataJurusanController::class, 'index'])->name('jurusan.index');
    Route::post('jurusan', [dataJurusanController::class, 'store'])->name('jurusan.store');
    Route::put('jurusan/{id}', [dataJurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('jurusan/{id}', [dataJurusanController::class, 'destroy'])->name('jurusan.destroy');
    
    // Rombel Bulk Actions
    Route::post('/rombel/bulk-store', [RombelController::class, 'bulkStore'])->name('rombel.bulkStore');
    Route::post('/rombel/bulk-add-jurusan', [RombelController::class, 'bulkAddJurusan'])->name('rombel.bulkAddJurusan');
    
    // Presensi
    Route::resource('presensi', PresensiController::class)->names([
        'index' => 'admin.presensi.index',
        'create' => 'admin.presensi.create',
        'store' => 'admin.presensi.store',
        'show' => 'admin.presensi.show',
        'edit' => 'admin.presensi.edit',
        'update' => 'admin.presensi.update',
        'destroy' => 'admin.presensi.destroy',
    ]);
    Route::get('/detail-siswa/{nis}', [PresensiController::class, 'detailSiswa'])->name('admin.detailSiswa');
    
    // Import Siswa
    Route::get('/siswa/import', [datasiswaController::class, 'showImportFrom'])->name('siswa.import.from');
    Route::post('/siswa/import', [datasiswaController::class, 'import'])->name('admin.siswa.import');
    
    // Export
    Route::get('/export-perbulan', [ExportExcelController::class, 'exportPerBulan'])->name('admin.export.perBulan');
    Route::get('/export-perkelas', [ExportExcelController::class, 'exportPerKelas'])->name('admin.export.perKelas');
    Route::get('/export-detail-siswa/{nis}', [ExportExcelController::class, 'exportDetailSiswa'])->name('admin.export.detailSiswa');
    
    // Akademik
    Route::prefix('naik-kelas')->name('admin.naikkelas.')->group(function() {
        Route::get('/', [NaikKelasController::class, 'index'])->name('index');
        Route::post('/proses', [NaikKelasController::class, 'prosesNaikKelas'])->name('proses');
        Route::post('/tidak-naik', [NaikKelasController::class, 'prosesTidakNaikKelas'])->name('tidaknaik');
    });
    
    Route::prefix('kelulusan')->name('admin.kelulusan.')->group(function() {
        Route::get('/', [KelulusanController::class, 'index'])->name('index');
        Route::post('/proses', [KelulusanController::class, 'prosesKelulusan'])->name('proses');
        Route::post('/cleanup', [KelulusanController::class, 'cleanupSiswaLulus'])->name('cleanup');
        Route::get('/check-siswa-lulus', [KelulusanController::class, 'checkSiswaLulus'])->name('check');
    });
    
    Route::prefix('alumni')->name('admin.alumni.')->group(function() {
        Route::get('/', [KelulusanController::class, 'daftarAlumni'])->name('index');
        Route::delete('/{id}', [KelulusanController::class, 'hapusAlumni'])->name('hapus');
    });
    
    // Monitoring Login
    Route::prefix('monitoring')->name('admin.monitoring.')->group(function() {
        Route::get('/login', [MonitoringLoginController::class, 'index'])->name('index');
        Route::get('/api/active-users', [MonitoringLoginController::class, 'getActiveUsers']);
        Route::get('/api/login-history', [MonitoringLoginController::class, 'getLoginHistory']);
        Route::get('/api/user-detail/{userId}', [MonitoringLoginController::class, 'getUserDetail']);
        Route::post('/api/force-logout', [MonitoringLoginController::class, 'forceLogout']);
    });
});

// ================================================
// USER (GURU) ROUTES
// ================================================
Route::middleware(['auth', 'role:user', 'check.activity'])->prefix('user')->group(function () {
    
    // Dashboard & Laporan
    Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/perkelas', [UserController::class, 'perKelas'])->name('user.perKelas');
    Route::get('/perbulan', [UserController::class, 'perBulan'])->name('user.perBulan');
    
    // Presensi
    Route::resource('presensi', UserPresensiController::class)->names([
        'index' => 'user.presensi.index',
        'create' => 'user.presensi.create',
        'store' => 'user.presensi.store',
        'show' => 'user.presensi.show',
        'edit' => 'user.presensi.edit',
        'update' => 'user.presensi.update',
        'destroy' => 'user.presensi.destroy',
    ]);
    Route::get('/detail-siswa/{nis}', [UserPresensiController::class, 'detailSiswa'])->name('user.detailSiswa');
    
    // Export
    Route::get('/export-perbulan', [ExportExcelController::class, 'exportPerBulan'])->name('user.export.perBulan');
    Route::get('/export-perkelas', [ExportExcelController::class, 'exportPerKelas'])->name('user.export.perKelas');
    Route::get('/export-detail-siswa/{nis}', [ExportExcelController::class, 'exportDetailSiswa'])->name('user.export.detailSiswa');
});

// ================================================
// AUTH ROUTES
// ================================================
require __DIR__ . '/auth.php';