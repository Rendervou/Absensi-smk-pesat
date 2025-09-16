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
                            ->take(5)
                            ->get();

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
        // Ambil semua data kelas
        $kelas = DataKelas::orderBy('nama_kelas')->get();
        
        // Tentukan semester berdasarkan request atau default semester 1
        $semester = $request->get('semester', 1);
        $monthNums = $semester == 1 ? [7, 8, 9, 10, 11, 12] : [1, 2, 3, 4, 5, 6];
        
        // Inisialisasi array untuk data bulanan dan total tahunan
        $dataBulan = [];
        $totalTahunan = [];
        
        // Loop untuk setiap kelas
        foreach ($kelas as $kls) {
            // Inisialisasi data per bulan untuk setiap kelas
            foreach ($monthNums as $month) {
                // Hitung data presensi per bulan per kelas
                $startDate = Carbon::create(null, $month, 1)->startOfMonth();
                $endDate = Carbon::create(null, $month, 1)->endOfMonth();
                
                // Jika bulan semester 1 (Juli-Desember), gunakan tahun sekarang
                // Jika bulan semester 2 (Januari-Juni), gunakan tahun sekarang
                if ($semester == 1 && $month >= 7) {
                    $year = now()->year;
                } elseif ($semester == 2 && $month <= 6) {
                    $year = now()->year;
                } else {
                    $year = now()->year;
                }
                
                $startDate = Carbon::create($year, $month, 1)->startOfMonth();
                $endDate = Carbon::create($year, $month, 1)->endOfMonth();
                
                // Ambil siswa yang ada di kelas ini
                $siswaIds = DataSiswa::where('id_kelas', $kls->id_kelas)->pluck('id_siswa');
                
                $hadir = Presensi::whereIn('id_siswa', $siswaIds)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'hadir')
                    ->count();
                    
                $izin = Presensi::whereIn('id_siswa', $siswaIds)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'izin')
                    ->count();
                    
                $sakit = Presensi::whereIn('id_siswa', $siswaIds)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'sakit')
                    ->count();
                    
                $alfa = Presensi::whereIn('id_siswa', $siswaIds)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'alfa')
                    ->count();
                
                $dataBulan[$kls->id_kelas][$month] = [
                    'hadir' => $hadir,
                    'izin' => $izin,
                    'sakit' => $sakit,
                    'alfa' => $alfa
                ];
            }
            
            // Hitung total tahunan (semua bulan)
            $siswaIds = DataSiswa::where('id_kelas', $kls->id_kelas)->pluck('id_siswa');
            
            // Untuk total tahunan, ambil data dari Juli tahun lalu sampai Juni tahun ini
            $startYear = $semester == 1 ? now()->year : now()->year - 1;
            $endYear = $semester == 1 ? now()->year : now()->year;
            
            $yearStartDate = Carbon::create($startYear, 7, 1)->startOfMonth();
            $yearEndDate = Carbon::create($endYear, 6, 30)->endOfMonth();
            
            $totalHadir = Presensi::whereIn('id_siswa', $siswaIds)
                ->whereBetween('tanggal', [$yearStartDate, $yearEndDate])
                ->where('status', 'hadir')
                ->count();
                
            $totalIzin = Presensi::whereIn('id_siswa', $siswaIds)
                ->whereBetween('tanggal', [$yearStartDate, $yearEndDate])
                ->where('status', 'izin')
                ->count();
                
            $totalSakit = Presensi::whereIn('id_siswa', $siswaIds)
                ->whereBetween('tanggal', [$yearStartDate, $yearEndDate])
                ->where('status', 'sakit')
                ->count();
                
            $totalAlfa = Presensi::whereIn('id_siswa', $siswaIds)
                ->whereBetween('tanggal', [$yearStartDate, $yearEndDate])
                ->where('status', 'alfa')
                ->count();
            
            $totalTahunan[$kls->id_kelas] = [
                'hadir' => $totalHadir,
                'izin' => $totalIzin,
                'sakit' => $totalSakit,
                'alfa' => $totalAlfa
            ];
        }
        
        return view('user.kelas', compact('kelas', 'dataBulan', 'totalTahunan'));
    }

    public function perBulan()
    {
        // $data = Absensi::orderBy('kelas')->get();
        return view('user.bulan');
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