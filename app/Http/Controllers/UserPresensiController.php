<?php

namespace App\Http\Controllers;

use App\Events\PresensiCreated;
use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Presensi;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class UserPresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswa = DataSiswa::all();
        $kelas = DataKelas::orderBy('nama_kelas', 'asc')->get();
        $jurusan = DataJurusan::orderBy('nama_jurusan', 'asc')->get();
        $presensi = Presensi::all();
        
        // Query dasar dengan leftJoin untuk menangani NULL jurusan
        $rombels = Rombel::join('data_kelas', 'data_kelas.id_kelas', '=', 'rombels.id_kelas')
            ->join('data_siswas', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
            ->leftJoin('data_jurusans', 'data_jurusans.id_jurusan', '=', 'rombels.id_jurusan')
            ->select(
                'data_siswas.id_siswa',
                'data_siswas.nis',
                'data_siswas.nama_siswa',
                'data_kelas.id_kelas',
                'data_kelas.nama_kelas',
                'data_jurusans.id_jurusan',
                'data_jurusans.nama_jurusan'
            );

        // Filter Kelas
        $kelasNama = null;
        if ($request->filled('kelas')) {
            $rombels->where('data_kelas.id_kelas', $request->kelas);
            $kelasNama = DataKelas::where('id_kelas', $request->kelas)->value('nama_kelas');
        }

        // Filter Jurusan
        $jurusanNama = null;
        if ($request->filled('jurusan')) {
            if ($request->jurusan == 'null') {
                // Filter untuk siswa yang belum memiliki jurusan
                $rombels->whereNull('rombels.id_jurusan');
                $jurusanNama = 'Belum Ada Jurusan';
            } else {
                // Filter untuk jurusan tertentu
                $rombels->where('rombels.id_jurusan', $request->jurusan);
                $jurusanNama = DataJurusan::where('id_jurusan', $request->jurusan)->value('nama_jurusan');
            }
        }

        $rombels = $rombels->orderBy('data_siswas.nama_siswa','asc')->get();
        
        return view('user.absensi', compact('presensi', 'rombels', 'siswa', 'kelas', 'jurusan', 'kelasNama', 'jurusanNama'));
    }

    public function detailSiswa(Request $request, $nis)
    {
        $bulan = $request->get('bulan', now()->month);
        $tahun = $request->get('tahun', now()->year);
        $status = $request->get('status');

        // Ambil data siswa
        $siswa = DataSiswa::where('nis', $nis)->firstOrFail();

        // Query dengan leftJoin untuk menangani NULL jurusan
        $rombel = Rombel::where('id_siswa', $siswa->id_siswa)
            ->join('data_kelas', 'rombels.id_kelas', '=', 'data_kelas.id_kelas')
            ->leftJoin('data_jurusans', 'rombels.id_jurusan', '=', 'data_jurusans.id_jurusan')
            ->select('data_kelas.nama_kelas', 'data_jurusans.nama_jurusan')
            ->first();

        // Query detail presensi dengan filter
        $query = Presensi::where('id_siswa', $siswa->id_siswa)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);
        
        // Terapkan filter status jika ada
        if ($status && in_array($status, ['hadir', 'sakit', 'izin', 'alfa'])) {
            $query->where('status', $status);
        }
        
        $detailPresensi = $query->orderBy('tanggal', 'asc')->get();

        // Hitung statistik (tetap dari semua data tanpa filter)
        $allPresensi = Presensi::where('id_siswa', $siswa->id_siswa)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $statistik = [
            'hadir' => $allPresensi->where('status', 'hadir')->count(),
            'sakit' => $allPresensi->where('status', 'sakit')->count(),
            'izin' => $allPresensi->where('status', 'izin')->count(),
            'alfa' => $allPresensi->where('status', 'alfa')->count(),
            'total' => $allPresensi->count()
        ];

        // Nama bulan dalam bahasa Indonesia
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('user.detail-siswa', compact(
            'siswa', 
            'rombel', 
            'detailPresensi', 
            'statistik', 
            'bulan', 
            'tahun',
            'namaBulan',
            'status'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi data
            $request->validate([
                'id_siswa' => 'required|array',
                'id_siswa.*' => 'required|exists:data_siswas,id_siswa',
                'id_kelas' => 'required|array',
                'id_kelas.*' => 'required|exists:data_kelas,id_kelas',
            ]);

            $id_siswa = $request->input('id_siswa', []);
            $id_kelas = $request->input('id_kelas', []);
            $tanggal  = now()->toDateString();
            $guru     = auth()->user();

            // Cek jika tidak ada data siswa
            if (empty($id_siswa)) {
                return redirect()->route('user.presensi.index')
                    ->with('error', 'Tidak ada data siswa yang dipilih.');
            }

            // Gunakan array_unique untuk menghindari duplikasi
            $id_siswa_unique = array_unique($id_siswa);

            DB::beginTransaction();

            $jumlahBerhasil = 0;
            $siswaProcessed = [];

            foreach ($id_siswa_unique as $index => $siswaId) {
                // Skip jika siswa sudah diproses
                if (in_array($siswaId, $siswaProcessed)) {
                    continue;
                }

                $kelasId = $id_kelas[$index] ?? null;
                
                if (!$kelasId) {
                    continue;
                }

                $siswa = DataSiswa::find($siswaId);
                $kelas = DataKelas::find($kelasId);

                if (!$siswa || !$kelas) {
                    continue;
                }

                // Ambil jurusan dari rombel (bisa NULL)
                $rombel = Rombel::where('id_siswa', $siswaId)
                    ->where('id_kelas', $kelasId)
                    ->leftJoin('data_jurusans', 'rombels.id_jurusan', '=', 'data_jurusans.id_jurusan')
                    ->select('data_jurusans.nama_jurusan')
                    ->first();

                $status = $request->input("kehadiran_{$siswaId}", 'hadir');

                Presensi::updateOrCreate(
                    [
                        'id_siswa' => $siswa->id_siswa,
                        'tanggal'  => $tanggal,
                    ],
                    [
                        'id_siswa'    => $siswa->id_siswa,
                        'id_kelas'    => $kelasId,
                        'id_user'     => $guru->id,
                        'nama_siswa'  => $siswa->nama_siswa,
                        'nama_kelas'  => $kelas->nama_kelas,
                        'nama_jurusan'=> $rombel ? $rombel->nama_jurusan : null,
                        'nama_guru'   => $guru->name,
                        'status'      => $status,
                        'tanggal'     => $tanggal,
                    ]
                );

                $siswaProcessed[] = $siswaId;
                $jumlahBerhasil++;
            }

            DB::commit();

            // Format tanggal dalam bahasa Indonesia
            $bulanIndo = [
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            ];
            
            $tanggalFormat = date('d', strtotime($tanggal)) . ' ' . 
                           $bulanIndo[date('n', strtotime($tanggal))] . ' ' . 
                           date('Y', strtotime($tanggal));

            return redirect()->route('user.presensi.index')
                ->with('success', "Presensi berhasil disimpan untuk {$jumlahBerhasil} siswa pada tanggal {$tanggalFormat}");

        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->route('user.presensi.index')
                ->with('error', 'Terjadi kesalahan saat menyimpan presensi: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}