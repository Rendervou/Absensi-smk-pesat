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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|min:2|max:255',
        ], [
            'nama_jurusan.required' => 'Nama jurusan harus diisi',
            'nama_jurusan.min' => 'Nama jurusan minimal 2 karakter',
            'nama_jurusan.max' => 'Nama jurusan maksimal 255 karakter',
        ]);

        try {
            DataJurusan::create([
                'nama_jurusan' => $request->nama_jurusan,
            ]);

            return redirect()->route('jurusan.index')
                ->with('success', 'Data jurusan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|min:2|max:255',
        ], [
            'nama_jurusan.required' => 'Nama jurusan harus diisi',
            'nama_jurusan.min' => 'Nama jurusan minimal 2 karakter',
            'nama_jurusan.max' => 'Nama jurusan maksimal 255 karakter',
        ]);

        try {
            $jurusan = DataJurusan::findOrFail($id);
            
            $jurusan->update([
                'nama_jurusan' => $request->nama_jurusan,
            ]);

            return redirect()->route('jurusan.index')
                ->with('success', 'Data jurusan berhasil diupdate!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Data jurusan tidak ditemukan!');
        } catch (\Exception $e) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $jurusan = DataJurusan::findOrFail($id);
            $jurusan->delete();

            return redirect()->route('jurusan.index')
                ->with('success', 'Data jurusan berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Data jurusan tidak ditemukan!');
        } catch (\Exception $e) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}