    <?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\dataJurusanController;
use App\Http\Controllers\datakelasController;
use App\Http\Controllers\datasiswaController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/rombel', [RombelController::class, 'index'])->name('admin.rombel');

    Route::get('/admin/perkelas', [AdminController::class, 'perKelas'])->name('admin.perKelas');
    Route::get('/admin/perbulan', [AdminController::class, 'perBulan'])->name('admin.perBulan');
    Route::resource('admin/siswa', datasiswaController::class);
    Route::resource('admin/presensi', PresensiController::class);
    Route::resource('admin/jurusan', dataJurusanController::class);
    Route::resource('admin/rombel', RombelController::class);
    Route::resource('admin/kelas', datakelasController::class);

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::resource('user/presensi', PresensiController::class);

    // Route::get('/user/absensi', [UserController::class, 'absensi'])->name('user.absensi');
});


require __DIR__ . '/auth.php';
