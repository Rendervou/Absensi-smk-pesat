<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function absensi()
    {
        return view('admin.absensi');
    }
    public function perKelas()
    {
        // $data = Absensi::orderBy('kelas')->get();
        return view('admin.kelas');
    }
    public function siswaBaru()
    {
        return view('admin.siswabaru');
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

    public function storeSiswaBaru(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|numeric|max:225',
            'no_tlp' => 'required|numeric|max:225',
            'alamat' => 'required|string',
        ]);

        // Logic to store the new student data
        // DataSiswa::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Siswa baru berhasil ditambahkan.');
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
