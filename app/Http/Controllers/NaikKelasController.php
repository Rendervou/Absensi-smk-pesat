<?php

namespace App\Http\Controllers;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\DataJurusan;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NaikKelasController extends Controller
{
    /**
     * Tampilkan halaman naik kelas massal
     */
    public function index(Request $request)
    {
        $kelas = DataKelas::orderBy('nama_kelas', 'asc')->get();
        
        $siswaList = collect();
        $kelasAsal = null;
        
        // Jika ada filter kelas
        if ($request->filled('kelas_asal')) {
            $kelasAsal = DataKelas::find($request->kelas_asal);
            
            if ($kelasAsal) {
                // Ambil siswa yang ada di rombel kelas ini
                $siswaList = Rombel::where('id_kelas', $request->kelas_asal)
                    ->with(['siswa', 'kelas', 'jurusan'])
                    ->get()
                    ->map(function ($rombel) {
                        return [
                            'id_siswa' => $rombel->id_siswa,
                            'nama_siswa' => $rombel->siswa->nama_siswa,
                            'nis' => $rombel->siswa->nis,
                            'kelas' => $rombel->kelas->nama_kelas,
                            'jurusan' => $rombel->jurusan->nama_jurusan ?? '-',
                            'id_jurusan' => $rombel->id_jurusan,
                            'status' => $rombel->siswa->status ?? 'aktif',
                            'id_rombel' => $rombel->id,
                        ];
                    });
            }
        }
        
        return view('admin.naikkelasMassal', compact('kelas', 'siswaList', 'kelasAsal'));
    }

    /**
     * Proses naik kelas massal
     */
    public function prosesNaikKelas(Request $request)
    {
        $request->validate([
            'kelas_tujuan' => 'required|exists:data_kelas,id_kelas',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswas,id_siswa',
        ], [
            'kelas_tujuan.required' => 'Kelas tujuan harus dipilih',
            'siswa_ids.required' => 'Minimal pilih 1 siswa untuk naik kelas',
            'siswa_ids.min' => 'Minimal pilih 1 siswa untuk naik kelas',
        ]);

        DB::beginTransaction();
        
        try {
            $naik = 0;
            $gagal = 0;
            $errors = [];

            foreach ($request->siswa_ids as $siswaId) {
                try {
                    // Update rombel siswa - hanya update kelas, jurusan tetap sama
                    $rombel = Rombel::where('id_siswa', $siswaId)->first();
                    
                    if ($rombel) {
                        $rombel->update([
                            'id_kelas' => $request->kelas_tujuan,
                            // id_jurusan tidak diubah, tetap menggunakan jurusan yang sama
                        ]);
                        
                        // Update status siswa menjadi aktif
                        DataSiswa::where('id_siswa', $siswaId)->update([
                            'status' => 'aktif'
                        ]);
                        
                        $naik++;
                    } else {
                        $errors[] = "Siswa ID $siswaId tidak ditemukan di rombel";
                        $gagal++;
                    }
                } catch (\Exception $e) {
                    Log::error("Error naik kelas siswa ID $siswaId: " . $e->getMessage());
                    $errors[] = "Gagal memproses siswa ID $siswaId";
                    $gagal++;
                }
            }

            DB::commit();

            // Buat pesan sukses
            $message = "$naik siswa berhasil naik kelas.";
            if ($gagal > 0) {
                $message .= " $gagal siswa gagal diproses.";
            }

            if (count($errors) > 0) {
                Log::warning('Errors saat naik kelas:', $errors);
            }

            return redirect()->route('admin.naikkelas.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error naik kelas massal: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal memproses naik kelas: ' . $e->getMessage());
        }
    }

    /**
     * Proses siswa yang tidak naik kelas
     */
    public function prosesTidakNaikKelas(Request $request)
    {
        $request->validate([
            'kelas_asal' => 'required|exists:data_kelas,id_kelas',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:data_siswas,id_siswa',
        ]);

        DB::beginTransaction();
        
        try {
            $updated = 0;

            foreach ($request->siswa_ids as $siswaId) {
                // Update status siswa menjadi tidak naik kelas
                DataSiswa::where('id_siswa', $siswaId)->update([
                    'status' => 'tidak_naik_kelas'
                ]);
                
                $updated++;
            }

            DB::commit();

            return redirect()->route('admin.naikkelas.index')
                ->with('success', "$updated siswa ditandai sebagai tidak naik kelas.");

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error tandai tidak naik kelas: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}