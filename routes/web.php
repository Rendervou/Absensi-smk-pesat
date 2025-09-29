    <?php

    use App\Http\Controllers\AdminController;
use App\Http\Controllers\dataguruController;
use App\Http\Controllers\dataJurusanController;
    use App\Http\Controllers\datakelasController;
    use App\Http\Controllers\datasiswaController;
    use App\Http\Controllers\PresensiController;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\RombelController;
    use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPresensiController;
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

    // Hapus resource presensi dari group yang pertama
    Route::middleware(['auth', 'role:admin'])->group(function(){
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/perkelas', [AdminController::class, 'perKelas'])->name('admin.perKelas');
        Route::get('/admin/perbulan', [AdminController::class, 'perBulan'])->name('admin.perBulan');
        Route::resource('admin/siswa', datasiswaController::class);
        Route::resource('admin/jurusan', dataJurusanController::class);
        Route::resource('admin/rombel', RombelController::class);
        Route::resource('admin/kelas', datakelasController::class);
        Route::resource('admin/guru', dataguruController::class);
        Route::get('/siswa/import', [datasiswaController::class, 'showImportFrom'])->name('siswa.import.from');
        Route::post('/siswa/import', [datasiswaController::class, 'import'])->name('admin.siswa.import'); 
    });

    // Biarkan yang ini saja
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

    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
        Route::get('/user/perkelas', [UserController::class, 'perKelas'])->name('user.perKelas');
        Route::get('/user/perbulan', [UserController::class, 'perBulan'])->name('user.perBulan');
        Route::resource('user/presensi', UserPresensiController::class);
    });

    // User
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
