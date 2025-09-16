<?php

namespace App\Http\Controllers;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Presensi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
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

        return view('admin.dashboard', compact(
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
        return view('admin.kelas', compact('kelas','dataBulan','totalTahunan'));
    }


    public function perBulan(Request $request)
    {
        $kelas = DataKelas::all();

        // Ambil dari query string ?kelas=...&bulan=...
        $bulan = $request->get('bulan', now()->month); 
        $id_kelas = $request->get('kelas');

        $siswaQuery = DataSiswa::with(['kelas','jurusan']);

        if ($id_kelas) {
            $siswaQuery->where('id_kelas', $id_kelas);
        }

        $siswaList = $siswaQuery->orderBy('nama_siswa', 'asc')->get();

        $rekap = [];

        foreach ($siswaList as $siswa) {
            $rekap[$siswa->id_siswa] = [
                'nama_siswa' => $siswa->nama_siswa,
                'kelas' => $siswa->kelas->nama_kelas ?? '-',
                'kompetensi' => $siswa->jurusan->nama_jurusan ?? '-',
                'S' => Presensi::where('id_siswa', $siswa->id_siswa)
                            ->whereMonth('tanggal', $bulan)
                            ->where('status','sakit')->count(),
                'I' => Presensi::where('id_siswa', $siswa->id_siswa)
                            ->whereMonth('tanggal', $bulan)
                            ->where('status','izin')->count(),
                'A' => Presensi::where('id_siswa', $siswa->id_siswa)
                            ->whereMonth('tanggal', $bulan)
                            ->where('status','alfa')->count(),
            ];
        }

        return view('admin.bulan', compact('rekap','kelas','bulan','id_kelas'));
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
