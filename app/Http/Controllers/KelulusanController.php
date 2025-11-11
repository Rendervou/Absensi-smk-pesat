<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class KelulusanController extends Controller
{
    /**
     * Tampilkan halaman kelulusan
     */
    public function index(Request $request)
    {
        // Ambil kelas XII
        $kelasXII = DataKelas::where('nama_kelas', 'like', 'XII%')
            ->orWhere('nama_kelas', 'like', '12%')
            ->get();
        
        $siswaList = collect();
        $kelasSelected = null;
        
        // Jika ada filter kelas
        if ($request->filled('kelas')) {
            $kelasSelected = DataKelas::find($request->kelas);
            
            if ($kelasSelected) {
                // Ambil siswa kelas XII yang belum lulus
                $siswaList = Rombel::where('id_kelas', $request->kelas)
                    ->with(['siswa', 'kelas', 'jurusan'])
                    ->whereHas('siswa', function($query) {
                        // Hanya ambil siswa yang masih aktif (belum lulus)
                        $query->whereNull('status')
                              ->orWhere('status', '!=', 'lulus');
                    })
                    ->get()
                    ->map(function ($rombel) {
                        return [
                            'id_siswa' => $rombel->id_siswa,
                            'nama_siswa' => $rombel->siswa->nama_siswa,
                            'nis' => $rombel->siswa->nis,
                            'no_tlp' => $rombel->siswa->no_tlp,
                            'kelas' => $rombel->kelas->nama_kelas,
                            'jurusan' => $rombel->jurusan->nama_jurusan ?? '-',
                            'id_kelas' => $rombel->id_kelas,
                            'id_jurusan' => $rombel->id_jurusan,
                            'id_rombel' => $rombel->id,
                        ];
                    });
            }
        }
        
        // Ambil data alumni untuk statistik
        $totalAlumni = Alumni::count();
        $alumniTahunIni = Alumni::where('tahun_lulus', date('Y'))->count();
        
        return view('admin.kelulusan', compact(
            'kelasXII', 
            'siswaList', 
            'kelasSelected', 
            'totalAlumni', 
            'alumniTahunIni'
        ));
    }

    /**
     * Proses kelulusan massal
     */
    public function prosesKelulusan(Request $request)
    {
        // Log request untuk debugging
        Log::info('=== MULAI PROSES KELULUSAN ===');
        Log::info('Request data:', $request->all());
        
        $request->validate([
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswas,id_siswa',
            'tanggal_kelulusan' => 'required|date',
            'catatan' => 'nullable|string|max:500',
        ], [
            'siswa_ids.required' => 'Minimal pilih 1 siswa untuk diluluskan',
            'siswa_ids.min' => 'Minimal pilih 1 siswa untuk diluluskan',
            'tanggal_kelulusan.required' => 'Tanggal kelulusan harus diisi',
        ]);

        DB::beginTransaction();
        
        try {
            $lulus = 0;
            $gagal = 0;
            $errors = [];
            $tahunLulus = Carbon::parse($request->tanggal_kelulusan)->year;

            Log::info("Tahun lulus: {$tahunLulus}");
            Log::info("Jumlah siswa yang akan diproses: " . count($request->siswa_ids));

            foreach ($request->siswa_ids as $siswaId) {
                try {
                    Log::info("--- Memproses siswa ID: {$siswaId} ---");
                    
                    // Ambil data siswa
                    $siswa = DataSiswa::find($siswaId);
                    
                    if (!$siswa) {
                        Log::error("Siswa ID {$siswaId} tidak ditemukan");
                        $errors[] = "Siswa ID $siswaId tidak ditemukan";
                        $gagal++;
                        continue;
                    }

                    Log::info("Data siswa:", [
                        'id' => $siswa->id_siswa,
                        'nama' => $siswa->nama_siswa,
                        'nis' => $siswa->nis
                    ]);

                    // Ambil data rombel terakhir
                    $rombel = Rombel::where('id_siswa', $siswaId)
                        ->with(['kelas', 'jurusan'])
                        ->first();
                    
                    if (!$rombel) {
                        Log::error("Data rombel untuk siswa {$siswa->nama_siswa} tidak ditemukan");
                        $errors[] = "Data rombel untuk {$siswa->nama_siswa} tidak ditemukan";
                        $gagal++;
                        continue;
                    }

                    Log::info("Data rombel:", [
                        'id_kelas' => $rombel->id_kelas,
                        'nama_kelas' => $rombel->kelas->nama_kelas,
                        'id_jurusan' => $rombel->id_jurusan,
                        'nama_jurusan' => $rombel->jurusan ? $rombel->jurusan->nama_jurusan : null
                    ]);

                    // Cek apakah sudah jadi alumni berdasarkan NIS
                    $existingAlumni = Alumni::where('nis', $siswa->nis)->first();
                    
                    if ($existingAlumni) {
                        Log::warning("{$siswa->nama_siswa} sudah terdaftar sebagai alumni");
                        $errors[] = "{$siswa->nama_siswa} sudah terdaftar sebagai alumni";
                        $gagal++;
                        continue;
                    }

                    // Prepare data alumni
                    $alumniData = [
                        'id_siswa' => $siswa->id_siswa,
                        'nama_siswa' => $siswa->nama_siswa,
                        'nis' => $siswa->nis,
                        'no_tlp' => $siswa->no_tlp,
                        'id_kelas_terakhir' => $rombel->id_kelas,
                        'nama_kelas_terakhir' => $rombel->kelas->nama_kelas,
                        'id_jurusan' => $rombel->id_jurusan,
                        'nama_jurusan' => $rombel->jurusan ? $rombel->jurusan->nama_jurusan : null,
                        'tahun_lulus' => $tahunLulus,
                        'tanggal_kelulusan' => $request->tanggal_kelulusan,
                        'catatan' => $request->catatan,
                    ];

                    Log::info("Data yang akan diinsert ke alumni:", $alumniData);

                    // Insert ke tabel alumni
                    $alumniCreated = Alumni::create($alumniData);
                    
                    Log::info("✅ Alumni berhasil dibuat dengan ID: " . $alumniCreated->id_alumni);

                    // Hapus data rombel siswa yang lulus
                    $rombel->delete();
                    Log::info("✅ Rombel berhasil dihapus");

                    // Hapus data siswa dari tabel data_siswas
                    $siswa->delete();
                    Log::info("✅ Data siswa berhasil dihapus dari tabel data_siswas");

                    $lulus++;

                    Log::info("✅✅✅ Siswa {$alumniData['nama_siswa']} berhasil diluluskan!");

                } catch (\Exception $e) {
                    Log::error("❌ Error kelulusan siswa ID $siswaId: " . $e->getMessage());
                    Log::error("Stack trace: " . $e->getTraceAsString());
                    $errors[] = "Gagal memproses siswa ID $siswaId: " . $e->getMessage();
                    $gagal++;
                }
            }

            DB::commit();

            Log::info("=== SELESAI PROSES KELULUSAN ===");
            Log::info("✅ Berhasil: {$lulus}, ❌ Gagal: {$gagal}");

            // Buat pesan sukses
            $message = "$lulus siswa berhasil diluluskan dan dipindahkan ke data alumni.";
            if ($gagal > 0) {
                $message .= " $gagal siswa gagal diproses.";
                if (count($errors) > 0) {
                    $message .= " Error: " . implode(', ', array_slice($errors, 0, 3));
                }
            }

            if (count($errors) > 0) {
                Log::warning('Errors saat kelulusan:', $errors);
            }

            return redirect()->route('admin.kelulusan.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('❌❌❌ ERROR FATAL kelulusan massal: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Gagal memproses kelulusan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan daftar alumni
     */
    public function daftarAlumni(Request $request)
    {
        $query = Alumni::orderBy('tahun_lulus', 'desc')
            ->orderBy('nama_siswa', 'asc');

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun_lulus', $request->tahun);
        }

        // Filter by kelas
        if ($request->filled('kelas')) {
            $query->where('nama_kelas_terakhir', 'like', '%' . $request->kelas . '%');
        }

        // Search by nama atau NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $alumni = $query->paginate(20)->withQueryString();
        
        // Tahun untuk filter
        $tahunList = Alumni::select('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus', 'desc')
            ->pluck('tahun_lulus');

        return view('admin.alumni', compact('alumni', 'tahunList'));
    }

    /**
     * Hapus data alumni dan kembalikan ke siswa aktif
     */
    public function hapusAlumni($id)
    {
        DB::beginTransaction();
        
        try {
            $alumni = Alumni::findOrFail($id);
            
            // Cek apakah siswa dengan NIS ini sudah ada di data_siswas
            $existingSiswa = DataSiswa::where('nis', $alumni->nis)->first();
            
            if ($existingSiswa) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Siswa dengan NIS ' . $alumni->nis . ' sudah ada di database siswa. Tidak bisa dikembalikan.');
            }
            
            // Kembalikan data siswa ke tabel data_siswas
            $siswa = DataSiswa::create([
                'nama_siswa' => $alumni->nama_siswa,
                'nis' => $alumni->nis,
                'no_tlp' => $alumni->no_tlp,
                'status' => 'aktif',
                'tahun_lulus' => null,
            ]);

            // Kembalikan ke rombel dengan kelas & jurusan terakhir
            Rombel::create([
                'id_siswa' => $siswa->id_siswa,
                'id_kelas' => $alumni->id_kelas_terakhir,
                'id_jurusan' => $alumni->id_jurusan,
            ]);

            // Hapus dari alumni
            $alumni->delete();

            DB::commit();

            Log::info("Alumni {$alumni->nama_siswa} berhasil dikembalikan ke data siswa aktif");

            return redirect()->back()
                ->with('success', 'Data alumni berhasil dihapus dan siswa dikembalikan ke status aktif.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error hapus alumni: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus data alumni: ' . $e->getMessage());
        }
    }

    /**
     * Hapus permanen siswa yang sudah lulus dari database SISWA (bukan ALUMNI!)
     */
    public function cleanupSiswaLulus()
    {
        DB::beginTransaction();
        
        try {
            $siswaLulus = DataSiswa::where('status', 'lulus')->get();
            
            $deleted = 0;
            $moved = 0;
            $details = [];
            
            foreach ($siswaLulus as $siswa) {
                $alumni = Alumni::where('nis', $siswa->nis)->first();
                
                if ($alumni) {
                    $details[] = "✅ {$siswa->nama_siswa} (NIS: {$siswa->nis}) - Dihapus dari database siswa";
                    Rombel::where('id_siswa', $siswa->id_siswa)->delete();
                    $siswa->delete();
                    $deleted++;
                } else {
                    $rombel = Rombel::where('id_siswa', $siswa->id_siswa)
                        ->with(['kelas', 'jurusan'])
                        ->first();
                    
                    Alumni::create([
                        'id_siswa' => $siswa->id_siswa,
                        'nama_siswa' => $siswa->nama_siswa,
                        'nis' => $siswa->nis,
                        'no_tlp' => $siswa->no_tlp,
                        'id_kelas_terakhir' => $rombel ? $rombel->id_kelas : null,
                        'nama_kelas_terakhir' => $rombel ? $rombel->kelas->nama_kelas : '-',
                        'id_jurusan' => $rombel ? $rombel->id_jurusan : null,
                        'nama_jurusan' => $rombel && $rombel->jurusan ? $rombel->jurusan->nama_jurusan : null,
                        'tahun_lulus' => $siswa->tahun_lulus ?? date('Y'),
                        'tanggal_kelulusan' => now(),
                        'catatan' => 'Data di-cleanup dari sistem lama',
                    ]);
                    
                    $details[] = "📦 {$siswa->nama_siswa} (NIS: {$siswa->nis}) - Dipindahkan ke alumni";
                    
                    if ($rombel) {
                        $rombel->delete();
                    }
                    
                    $siswa->delete();
                    $moved++;
                }
            }
            
            DB::commit();
            
            $totalProcessed = $deleted + $moved;
            
            Log::info("Cleanup berhasil: {$deleted} duplikat dihapus, {$moved} dipindahkan", $details);
            
            $message = "Berhasil membersihkan {$totalProcessed} data siswa. ({$deleted} duplikat dihapus, {$moved} dipindahkan ke alumni)";
            
            return redirect()->back()->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error cleanup: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
    
    /**
     * Cek jumlah siswa lulus yang masih ada di database
     */
    public function checkSiswaLulus()
    {
        try {
            $siswaLulus = DataSiswa::where('status', 'lulus')->get();
            $count = $siswaLulus->count();
            
            $data = $siswaLulus->map(function($siswa) {
                $alumni = Alumni::where('nis', $siswa->nis)->first();
                return [
                    'nama' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'status' => $siswa->status,
                    'sudah_alumni' => $alumni ? 'Ya' : 'Belum',
                ];
            });
            
            return response()->json([
                'success' => true,
                'count' => $count,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}