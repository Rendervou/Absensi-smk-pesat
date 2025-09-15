<?php

namespace App\Http\Controllers;

use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Presensi;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Models\User;

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
    
    public function perKelas()
    {
        // $data = Absensi::orderBy('kelas')->get();
        return view('user.kelas');
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
