<?php

namespace App\Http\Controllers;

use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Rombel;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    public function index()
    {
        $siswa = DataSiswa::all();
        $kelas = DataKelas::all();
        $jurusan = DataJurusan::all();

        $rombels = Rombel::join('data_kelas', 'data_kelas.id_kelas', '=', 'rombels.id_kelas')
            ->join('data_siswas', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
            ->join('data_jurusans', 'data_jurusans.id_jurusan', '=', 'rombels.id_jurusan')
            ->select('rombels.*', 'data_siswas.nama_siswa', 'data_kelas.nama_kelas', 'data_jurusans.nama_jurusan')
            ->paginate(10);

        return view('admin.rombel', compact('jurusan', 'kelas', 'siswa', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:data_siswas,id_siswa',
            'id_kelas' => 'required|exists:data_kelas,id_kelas',
            'id_jurusan' => 'required|exists:data_jurusans,id_jurusan',
        ]);

        Rombel::create([
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('rombel.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id)
    {
        $rombel = Rombel::findOrFail($id);
        $siswa = DataSiswa::all();
        $kelas = DataKelas::all();
        $jurusan = DataJurusan::all();

        return view('rombel.edit', compact('rombel', 'siswa', 'kelas', 'jurusan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_siswa' => 'required|exists:data_siswas,id_siswa',
            'id_kelas' => 'required|exists:data_kelas,id_kelas',
            'id_jurusan' => 'required|exists:data_jurusans,id_jurusan',
        ]);

        $rombel = Rombel::findOrFail($id);
        $rombel->update([
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('rombel.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $rombel = Rombel::findOrFail($id);
        $rombel->delete();

        return redirect()->route('rombel.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
