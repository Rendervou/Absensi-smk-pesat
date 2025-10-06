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
        Route::post('/admin/rombel/bulk-store', [RombelController::class, 'bulkStore'])->name('rombel.bulkStore');
        Route::resource('admin/kelas', datakelasController::class);
        Route::resource('admin/guru', dataguruController::class);
        Route::get('/siswa/import', [datasiswaController::class, 'showImportFrom'])->name('siswa.import.from');
        Route::post('/siswa/import', [datasiswaController::class, 'import'])->name('admin.siswa.import');
        Route::get('/admin/export-perbulan', [ExportExcelController::class, 'exportPerBulan'])->name('admin.export.perBulan');
        Route::get('/admin/export-perkelas', [ExportExcelController::class, 'exportPerKelas'])->name('admin.export.perKelas');
        Route::get('/admin/detail-siswa/{nis}', [PresensiController::class, 'detailSiswa'])->name('admin.detailSiswa');
        
        // ==================== ROUTES NAIK KELAS MASSAL ====================
        Route::get('/admin/naik-kelas', [App\Http\Controllers\NaikKelasController::class, 'index'])->name('admin.naikkelas.index');
        Route::post('/admin/naik-kelas/proses', [App\Http\Controllers\NaikKelasController::class, 'prosesNaikKelas'])->name('admin.naikkelas.proses');
        Route::post('/admin/naik-kelas/tidak-naik', [App\Http\Controllers\NaikKelasController::class, 'prosesTidakNaikKelas'])->name('admin.naikkelas.tidaknaik');

        // ==================== ROUTES KELULUSAN ====================
        Route::get('/admin/kelulusan', [App\Http\Controllers\KelulusanController::class, 'index'])->name('admin.kelulusan.index');
        Route::post('/admin/kelulusan/proses', [App\Http\Controllers\KelulusanController::class, 'prosesKelulusan'])->name('admin.kelulusan.proses');

        // ==================== ROUTES ALUMNI ====================
        Route::get('/admin/alumni', [App\Http\Controllers\KelulusanController::class, 'daftarAlumni'])->name('admin.alumni.index');
        Route::delete('/admin/alumni/{id}', [App\Http\Controllers\KelulusanController::class, 'hapusAlumni'])->name('admin.alumni.hapus');
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
        Route::get('/user/export-perbulan', [ExportExcelController::class, 'exportPerBulan'])->name('user.export.perBulan');
        Route::get('/user/export-perkelas', [ExportExcelController::class, 'exportPerKelas'])->name('user.export.perKelas');
        Route::get('/user/detail-siswa/{nis}', [UserPresensiController::class, 'detailSiswa'])->name('user.detailSiswa');
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

    // Tambahkan route test ini di routes/web.php untuk debug:

    Route::get('/test-query', function() {
        // 1. Cek data kelas XI-1
        $kelasXI1 = \App\Models\DataKelas::where('nama_kelas', 'XI-1')->first();
        echo "Kelas XI-1:<br>";
        echo "ID Kelas: " . ($kelasXI1 ? $kelasXI1->id_kelas : 'TIDAK ADA') . "<br>";
        echo "Nama: " . ($kelasXI1 ? $kelasXI1->nama_kelas : 'TIDAK ADA') . "<br><br>";
        
        // 2. Cek semua presensi bulan Oktober (bulan 10)
        echo "=== Presensi Bulan Oktober ===<br>";
        $presensiOkt = \App\Models\Presensi::whereMonth('tanggal', 10)
            ->select('id_presensi', 'id_kelas', 'nama_kelas', 'tanggal', 'status')
            ->get();
        
        echo "Total presensi Oktober: " . $presensiOkt->count() . "<br>";
        foreach($presensiOkt as $p) {
            echo "ID: {$p->id_presensi}, id_kelas: {$p->id_kelas}, nama_kelas: {$p->nama_kelas}, tanggal: {$p->tanggal}, status: {$p->status}<br>";
        }
        echo "<br>";
        
        // 3. Cek presensi XI-1 di Oktober
        echo "=== Presensi XI-1 di Oktober ===<br>";
        if ($kelasXI1) {
            $presensiXI1_byId = \App\Models\Presensi::where('id_kelas', $kelasXI1->id_kelas)
                ->whereMonth('tanggal', 10)
                ->count();
            echo "Query by id_kelas ({$kelasXI1->id_kelas}): {$presensiXI1_byId} data<br>";
        }
        
        $presensiXI1_byName = \App\Models\Presensi::where('nama_kelas', 'XI-1')
            ->whereMonth('tanggal', 10)
            ->count();
        echo "Query by nama_kelas (XI-1): {$presensiXI1_byName} data<br><br>";
        
        // 4. Cek presensi XI-1 dengan query OR
        if ($kelasXI1) {
            $presensiXI1_or = \App\Models\Presensi::where(function($query) use ($kelasXI1) {
                    $query->where('id_kelas', $kelasXI1->id_kelas)
                        ->orWhere('nama_kelas', $kelasXI1->nama_kelas);
                })
                ->whereMonth('tanggal', 10)
                ->get();
            
            echo "Query with OR (id_kelas OR nama_kelas): {$presensiXI1_or->count()} data<br>";
            foreach($presensiXI1_or as $p) {
                echo "- ID: {$p->id_presensi}, id_kelas: {$p->id_kelas}, nama_kelas: {$p->nama_kelas}, status: {$p->status}<br>";
            }
        }
        
        // 5. Test aggregation query
        echo "<br>=== Test Aggregation Query ===<br>";
        if ($kelasXI1) {
            $counts = \App\Models\Presensi::where(function($query) use ($kelasXI1) {
                    $query->where('id_kelas', $kelasXI1->id_kelas)
                        ->orWhere('nama_kelas', $kelasXI1->nama_kelas);
                })
                ->whereMonth('tanggal', 10)
                ->selectRaw("
                    SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as alfa
                ")->first();
            
            echo "Hadir: {$counts->hadir}<br>";
            echo "Izin: {$counts->izin}<br>";
            echo "Sakit: {$counts->sakit}<br>";
            echo "Alfa: {$counts->alfa}<br>";
        }
    });

    require __DIR__ . '/auth.php';
