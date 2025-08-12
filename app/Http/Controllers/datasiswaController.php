<?php

namespace App\Http\Controllers;

use App\Models\DataSiswa;
use Illuminate\Http\Request;

class datasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_siswa = DataSiswa::all();
        return view('admin.absensi', compact('data_siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.siswabaru');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $request->validate([
            'nama_siswa' => 'required|min:2',
            'nis' => 'required|min:2',
            'kompetensi_keahlian' => 'required|min:2',
        ]);

        DataSiswa::create([
            'nama_siswa'=> $request->nama_siswa,
            'nis'=> $request->nis,
            'kompetensi_keahlian'=> $request->kompetensi_keahlian,
        ]);

         return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
