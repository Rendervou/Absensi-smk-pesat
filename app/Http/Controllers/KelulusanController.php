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
                // Ambil siswa kelas XII
                $siswaList = Rombel::where('id_kelas', $request->kelas)
                    ->with(['siswa', 'kelas', 'jurusan'])
                    ->whereHas('siswa', function($query) {
                        $query->where('status', '!=', 'lulus'); // Hanya yang belum lulus
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

            foreach ($request->siswa_ids as $siswaId) {
                try {
                    // Ambil data siswa
                    $siswa = DataSiswa::find($siswaId);
                    
                    if (!$siswa) {
                        $errors[] = "Siswa ID $siswaId tidak ditemukan";
                        $gagal++;
                        continue;
                    }

                    // Ambil data rombel terakhir
                    $rombel = Rombel::where('id_siswa', $siswaId)
                        ->with(['kelas', 'jurusan'])
                        ->first();
                    
                    if (!$rombel) {
                        $errors[] = "Data rombel untuk {$siswa->nama_siswa} tidak ditemukan";
                        $gagal++;
                        continue;
                    }

                    // Cek apakah sudah jadi alumni
                    $existingAlumni = Alumni::where('id_siswa', $siswaId)->first();
                    
                    if ($existingAlumni) {
                        $errors[] = "{$siswa->nama_siswa} sudah terdaftar sebagai alumni";
                        $gagal++;
                        continue;
                    }

                    // Insert ke tabel alumni
                    Alumni::create([
                        'id_siswa' => $siswa->id_siswa,
                        'nama_siswa' => $siswa->nama_siswa,
                        'nis' => $siswa->nis,
                        'no_tlp' => $siswa->no_tlp,
                        'id_kelas_terakhir' => $rombel->id_kelas,
                        'nama_kelas_terakhir' => $rombel->kelas->nama_kelas,
                        'id_jurusan' => $rombel->id_jurusan,
                        'nama_jurusan' => $rombel->jurusan->nama_jurusan ?? null,
                        'tahun_lulus' => $tahunLulus,
                        'tanggal_kelulusan' => $request->tanggal_kelulusan,
                        'catatan' => $request->catatan,
                    ]);

                    // Update status siswa menjadi lulus
                    $siswa->update([
                        'status' => 'lulus',
                        'tahun_lulus' => $tahunLulus,
                    ]);

                    // Archive rombel (soft delete jika ada fitur)
                    // Atau bisa dibiarkan untuk history
                    // $rombel->delete();

                    $lulus++;

                } catch (\Exception $e) {
                    Log::error("Error kelulusan siswa ID $siswaId: " . $e->getMessage());
                    $errors[] = "Gagal memproses siswa ID $siswaId";
                    $gagal++;
                }
            }

            DB::commit();

            // Buat pesan sukses
            $message = "$lulus siswa berhasil diluluskan dan dipindahkan ke data alumni.";
            if ($gagal > 0) {
                $message .= " $gagal siswa gagal diproses.";
            }

            if (count($errors) > 0) {
                Log::warning('Errors saat kelulusan:', $errors);
            }

            return redirect()->route('admin.kelulusan.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error kelulusan massal: ' . $e->getMessage());
            
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
            $query->where('nama_kelas_terakhir', $request->kelas);
        }

        $alumni = $query->paginate(20);
        
        // Tahun untuk filter
        $tahunList = Alumni::select('tahun_lulus')
            ->distinct()
            ->orderBy('tahun_lulus', 'desc')
            ->pluck('tahun_lulus');

        return view('admin.alumni', compact('alumni', 'tahunList'));
    }

    /**
     * Hapus data alumni (jika diperlukan)
     */
    public function hapusAlumni($id)
    {
        try {
            $alumni = Alumni::findOrFail($id);
            
            // Kembalikan status siswa ke aktif
            DataSiswa::where('id_siswa', $alumni->id_siswa)->update([
                'status' => 'aktif',
                'tahun_lulus' => null,
            ]);
            
            $alumni->delete();

            return redirect()->back()
                ->with('success', 'Data alumni berhasil dihapus dan siswa dikembalikan ke status aktif.');

        } catch (\Exception $e) {
            Log::error('Error hapus alumni: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus data alumni: ' . $e->getMessage());
        }
    }
}