<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class datasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = DataSiswa::orderBy('nama_siswa', 'asc')->paginate(10);
        return view('admin.siswa', compact('siswa'));
    }

    public function showImportFrom()
    {
        return view('siswa.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new SiswaImport(6), $request->file('file'));

        return redirect()->back()->with('success', 'data siswa berhasil ditambahkan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $request->validate([
            'nama_siswa' => 'required|min:2',
            'nis' => 'required|min:2',
        ]);

        DataSiswa::create([
            'nama_siswa'=> $request->nama_siswa,
            'nis'=> $request->nis,
        ]);

         return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
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
        $s = DataSiswa::findOrFail($id);

        //render view with product
        return view('siswa.edit', compact('siswa'), [ 'title' => 'Edit Data']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_siswa' => 'required|min:2',
            'nis' => 'required|min:2',
        ]);

        //get product by ID
        $s = DataSiswa::findOrFail($id);
        $s->update([
            'nama_siswa'=> $request->nama_siswa,
            'nis'=> $request->nis,
        ]);

        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = DataSiswa::findOrFail($id);


        //delete product
        $siswa->delete();

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
