<?php

namespace App\Http\Controllers;

use App\Models\DataJurusan;
use Illuminate\Http\Request;

class dataJurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusan = DataJurusan::all();
        return view('admin.jurusan', compact('jurusan'));
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
        $request->validate([
            'nama_jurusan' => 'required|min:2',
        ]);

        DataJurusan::create([
            'nama_jurusan'=> $request->nama_jurusan,
        ]);

         return redirect()->route('jurusan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(DataJurusan $DataJurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
                $j = DataJurusan::findOrFail($id);

        //render view with product
        return view('jurusan.edit', compact('jurusan'), [ 'title' => 'Edit Data']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
                $request->validate([
            'nama_jurusan' => 'required|min:2',
        ]);

        //get product by ID
        $j = DataJurusan::findOrFail($id);
        $j->update([
            'nama_jurusan'=> $request->nama_jurusan,

        ]);

        return redirect()->route('jurusan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                $jurusan = DataJurusan::findOrFail($id);


        //delete product
        $jurusan->delete();

        //redirect to index
        return redirect()->route('jurusan.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
