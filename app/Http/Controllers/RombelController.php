<?php

namespace App\Http\Controllers;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Rombel;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = DataSiswa::all();
        $kelas = DataKelas::all();
        $rombels = Rombel::join('data_kelas', 'data_kelas.id_kelas', '=', 'rombels.id_kelas')
        ->join('data_siswas', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
        ->select('data_siswas.*', 'data_kelas.*')
        ->paginate(10);

        return view('admin.rombel', compact('kelas','siswa','rombels'));
        
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
            'id_siswa' => 'required|exists:data_siswas,id_siswa',
            'id_kelas' => 'required|exists:data_kelas,id_kelas',
        ]);

        Rombel::create([
            'id_siswa'=> $request->id_siswa,
            'id_kelas'=> $request->id_kelas,
        ]);

         return redirect()->route('admin.rombel')->with(['success' => 'Data Berhasil Disimpan!']);

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
        
        $rombels = Rombel::findOrFail($id);


        //delete product
        $rombels->delete();

        //redirect to index
        return redirect()->route('admin.rombel')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
