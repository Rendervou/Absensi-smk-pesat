<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\dataguruController;
use App\Http\Controllers\dataJurusanController;
use App\Http\Controllers\datakelasController;
use App\Http\Controllers\datasiswaController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPresensiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/perkelas', [AdminController::class, 'perKelas'])->name('admin.perKelas');
    Route::get('/admin/perbulan', [AdminController::class, 'perBulan'])->name('admin.perBulan');
    
    // Resource Routes dengan parameter yang benar
    Route::resource('admin/siswa', datasiswaController::class);
    
    // PERBAIKAN: Route jurusan dengan parameter id_jurusan
    Route::get('admin/jurusan', [dataJurusanController::class, 'index'])->name('jurusan.index');
    Route::post('admin/jurusan', [dataJurusanController::class, 'store'])->name('jurusan.store');
    Route::put('admin/jurusan/{id}', [dataJurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('admin/jurusan/{id}', [dataJurusanController::class, 'destroy'])->name('jurusan.destroy');
    
    Route::resource('admin/rombel', RombelController::class);
    Route::post('/admin/rombel/bulk-store', [RombelController::class, 'bulkStore'])->name('rombel.bulkStore');
    Route::resource('admin/kelas', datakelasController::class);
    Route::resource('admin/guru', dataguruController::class);
    
    // Import/Export
    Route::get('/siswa/import', [datasiswaController::class, 'showImportFrom'])->name('siswa.import.from');
    Route::post('/siswa/import', [datasiswaController::class, 'import'])->name('admin.siswa.import');
    Route::get('/admin/export-perbulan', [ExportExcelController::class, 'exportPerBulan'])->name('admin.export.perBulan');
    Route::get('/admin/export-perkelas', [ExportExcelController::class, 'exportPerKelas'])->name('admin.export.perKelas');
    Route::get('/admin/export-detail-siswa/{nis}', [ExportExcelController::class, 'exportDetailSiswa'])->name('admin.export.detailSiswa');
    Route::get('/admin/detail-siswa/{nis}', [PresensiController::class, 'detailSiswa'])->name('admin.detailSiswa');
    
    // Naik Kelas
    Route::get('/admin/naik-kelas', [App\Http\Controllers\NaikKelasController::class, 'index'])->name('admin.naikkelas.index');
    Route::post('/admin/naik-kelas/proses', [App\Http\Controllers\NaikKelasController::class, 'prosesNaikKelas'])->name('admin.naikkelas.proses');
    Route::post('/admin/naik-kelas/tidak-naik', [App\Http\Controllers\NaikKelasController::class, 'prosesTidakNaikKelas'])->name('admin.naikkelas.tidaknaik');

    // Kelulusan
    Route::get('/admin/kelulusan', [App\Http\Controllers\KelulusanController::class, 'index'])->name('admin.kelulusan.index');
    Route::post('/admin/kelulusan/proses', [App\Http\Controllers\KelulusanController::class, 'prosesKelulusan'])->name('admin.kelulusan.proses');

    // Alumni
    Route::get('/admin/alumni', [App\Http\Controllers\KelulusanController::class, 'daftarAlumni'])->name('admin.alumni.index');
    Route::delete('/admin/alumni/{id}', [App\Http\Controllers\KelulusanController::class, 'hapusAlumni'])->name('admin.alumni.hapus');
});

// Presensi Admin
Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::resource('presensi', PresensiController::class)->names([
        'index' => 'admin.presensi.index',
        'create' => 'admin.presensi.create',
        'store' => 'admin.presensi.store',
        'show' => 'admin.presensi.show',
        'edit' => 'admin.presensi.edit',
        'update' => 'admin.presensi.update',
        'destroy' => 'admin.presensi.destroy',
    ]);
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/perkelas', [UserController::class, 'perKelas'])->name('user.perKelas');
    Route::get('/user/perbulan', [UserController::class, 'perBulan'])->name('user.perBulan');
    Route::get('/user/export-perbulan', [ExportExcelController::class, 'exportPerBulan'])->name('user.export.perBulan');
    Route::get('/user/export-perkelas', [ExportExcelController::class, 'exportPerKelas'])->name('user.export.perKelas');
    Route::get('/user/export-detail-siswa/{nis}', [ExportExcelController::class, 'exportDetailSiswa'])->name('user.export.detailSiswa');
    Route::get('/user/detail-siswa/{nis}', [UserPresensiController::class, 'detailSiswa'])->name('user.detailSiswa');
});

// Presensi User
Route::prefix('user')->middleware(['auth','role:user'])->group(function () {
    Route::resource('presensi', UserPresensiController::class)->names([
        'index' => 'user.presensi.index',
        'create' => 'user.presensi.create',
        'store' => 'user.presensi.store',
        'show' => 'user.presensi.show',
        'edit' => 'user.presensi.edit',
        'update' => 'user.presensi.update',
        'destroy' => 'user.presensi.destroy',
    ]);
});

require __DIR__ . '/auth.php';