    <?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');
Route::get('/user/absensi', function () {
    return view('user.absensi');
})->name('user.absensi');
Route::get('/inputkehadiran', function () {
    return view('inputkehadiran');
})->middleware(['auth'])->name('inputkehadiran');

Route::get('/persiswa/siswa', function () {
    return view('persiswa.siswa');
})->middleware(['auth', 'verified'])->name('persiswa.siswa');

Route::get('/perkelas/kelas', function () {
    return view('perkelas.kelas');
})->middleware(['auth', 'verified'])->name('perkelas.kelas');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/absensi', [AdminController::class, 'absensi'])->name('admin.absensi');
});


require __DIR__ . '/auth.php';
