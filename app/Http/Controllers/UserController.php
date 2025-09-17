<?php

namespace App\Http\Controllers;

use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Presensi;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Total siswa
        $totalSiswa = DataSiswa::count();

        // Hitung absensi hari ini
        $today = now()->toDateString();

        $hadir = Presensi::where('tanggal', $today)
                    ->where('status', 'hadir')
                    ->count();

        $izin = Presensi::where('tanggal', $today)
                    ->where('status', 'izin')
                    ->count();

        $sakit = Presensi::where('tanggal', $today)
                    ->where('status', 'sakit')
                    ->count();

        $alfa = Presensi::where('tanggal', $today)
                    ->where('status', 'alfa')
                    ->count();

        // Ambil 5 data terbaru
        $latestPresensi = Presensi::with('siswa')
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('user.dashboard', compact(
            'totalSiswa',
            'hadir',
            'izin',
            'sakit',
            'alfa',
            'latestPresensi'
        ));
    }
    
    public function perKelas(Request $request)
    {
        // Ambil semua kelas (pastikan model DataKelas punya primaryKey id_kelas)
        $kelas = DataKelas::orderBy('nama_kelas')->get();

        // Inisialisasi struktur data
        $dataBulan = [];       // [id_kelas][bulan_number] => ['hadir'=>..,'izin'=>..,'sakit'=>..,'alfa'=>..]
        $totalTahunan = [];    // [id_kelas] => totals

        // Loop tiap kelas dan tiap bulan 1..12
        foreach ($kelas as $k) {
            $totalTahunan[$k->id_kelas] = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alfa' => 0];

            for ($m = 1; $m <= 12; $m++) {
                // Ambil agregasi per status untuk bulan m dan kelas ini
                $counts = Presensi::where('id_kelas', $k->id_kelas)
                    ->whereMonth('tanggal', $m)
                    ->selectRaw("
                        SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as hadir,
                        SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as izin,
                        SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as sakit,
                        SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as alfa
                    ")->first();

                // Pastikan integer
                $h = (int) ($counts->hadir ?? 0);
                $i = (int) ($counts->izin ?? 0);
                $s = (int) ($counts->sakit ?? 0);
                $a = (int) ($counts->alfa ?? 0);

                // Simpan per bulan
                $dataBulan[$k->id_kelas][$m] = [
                    'hadir' => $h,
                    'izin'  => $i,
                    'sakit' => $s,
                    'alfa'  => $a,
                ];

                // Tambah ke total tahunan
                $totalTahunan[$k->id_kelas]['hadir'] += $h;
                $totalTahunan[$k->id_kelas]['izin']  += $i;
                $totalTahunan[$k->id_kelas]['sakit'] += $s;
                $totalTahunan[$k->id_kelas]['alfa']  += $a;
            }
        }

        // Kirim ke view: pastikan view kamu (admin.kelas) memakai variabel ini
        return view('user.kelas', compact('kelas','dataBulan','totalTahunan'));
    }

    public function perBulan(Request $request)
    {
        $bulan = $request->get('bulan', now()->month);
        $id_kelas = $request->get('kelas');
        $selected_jurusan = $request->get('jurusan');
        $search = $request->get('search');

        $kelas = DataKelas::all();
        $jurusan = DataJurusan::all();

        // Query siswa lewat Rombel supaya bisa filter kelas & jurusan
        $siswaQuery = DataSiswa::join('rombels', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
            ->join('data_kelas', 'rombels.id_kelas', '=', 'data_kelas.id_kelas')
            ->join('data_jurusans', 'rombels.id_jurusan', '=', 'data_jurusans.id_jurusan')
            ->select('data_siswas.*', 'data_kelas.nama_kelas', 'data_jurusans.nama_jurusan');

        // Filter kelas
        if ($id_kelas) {
            $siswaQuery->where('data_kelas.id_kelas', $id_kelas);
        }

        // Filter jurusan
        if ($selected_jurusan) {
            $siswaQuery->where('data_jurusans.id_jurusan', $selected_jurusan);
        }

        // Search (by nama or nis)
        if ($search) {
            $siswaQuery->where(function ($q) use ($search) {
                $q->where('data_siswas.nama_siswa', 'like', "%{$search}%")
                ->orWhere('data_siswas.nis', 'like', "%{$search}%");
            });
        }

        // Ambil daftar siswa sesuai filter
        $siswaList = $siswaQuery->get();

        // Ambil rekap presensi per siswa
        $rekapPresensi = Presensi::select(
                'id_siswa',
                DB::raw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as S"),
                DB::raw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as I"),
                DB::raw("SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as A")
            )
            ->whereMonth('tanggal', $bulan)
            ->groupBy('id_siswa')
            ->get()
            ->keyBy('id_siswa');

        $rekap = [];
        foreach ($siswaList as $siswa) {
            $rekapData = $rekapPresensi[$siswa->id_siswa] ?? null;

            $rekap[$siswa->nis] = [
                'nama_siswa' => $siswa->nama_siswa,
                'kelas'      => $siswa->nama_kelas ?? '-',
                'kompetensi' => $siswa->nama_jurusan ?? '-',
                'S'          => $rekapData->S ?? 0,
                'I'          => $rekapData->I ?? 0,
                'A'          => $rekapData->A ?? 0,
            ];
        }

        return view('user.bulan', compact(
            'rekap', 'bulan', 'kelas', 'jurusan', 'id_kelas', 'selected_jurusan', 'search'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}