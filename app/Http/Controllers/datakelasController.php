<?php

namespace App\Http\Controllers;

use App\Models\DataKelas;
use Illuminate\Http\Request;

class datakelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = DataKelas::orderBy('nama_kelas', 'asc')->get();
        return view('admin.kelasbaru', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kelasbaru');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|min:2',
        ]);
        
        DataKelas::create([
            'nama_kelas'=> $request->nama_kelas,
        ]);

        return redirect()->route('kelas.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
        // Validasi input
        $request->validate([
            'nama_kelas' => 'required|min:2',
        ]);

        // Cari data kelas berdasarkan ID
        $kelas = DataKelas::findOrFail($id);

        // Update data
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('kelas.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = DataKelas::findOrFail($id);

        // Delete data
        $kelas->delete();

        // Redirect to index
        return redirect()->route('kelas.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}