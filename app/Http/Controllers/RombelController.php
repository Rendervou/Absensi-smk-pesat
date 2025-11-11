<?php

namespace App\Http\Controllers;

use App\Events\PresensiCreated;
use App\Models\DataJurusan;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\Presensi;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Siswa yang BELUM masuk rombel (untuk tambah baru)
        $siswa = DataSiswa::whereNotIn('id_siswa', function($query) {
            $query->select('id_siswa')->from('rombels');
        })->orderBy('nama_siswa', 'asc')->get();
        
        // Siswa yang SUDAH di rombel tapi BELUM punya jurusan (untuk tambah jurusan massal)
        $siswaNoJurusan = Rombel::join('data_siswas', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
            ->join('data_kelas', 'data_kelas.id_kelas', '=', 'rombels.id_kelas')
            ->whereNull('rombels.id_jurusan')
            ->select('rombels.id', 'rombels.id_siswa', 'rombels.id_kelas', 'data_siswas.nama_siswa', 'data_siswas.nis', 'data_kelas.nama_kelas')
            ->orderBy('data_siswas.nama_siswa', 'asc')
            ->get();
        
        // Semua siswa (untuk edit)
        $allSiswa = DataSiswa::all();
        
        $kelas = DataKelas::orderBy('nama_kelas', 'asc')->get();
        $jurusan = DataJurusan::orderBy('nama_jurusan', 'asc')->get();
        
        // Query rombel dengan join
        $rombels = Rombel::join('data_kelas', 'data_kelas.id_kelas', '=', 'rombels.id_kelas')
        ->join('data_siswas', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
        ->leftJoin('data_jurusans', 'data_jurusans.id_jurusan', '=', 'rombels.id_jurusan')
        ->select('rombels.*', 'data_siswas.nama_siswa', 'data_siswas.nis', 'data_kelas.nama_kelas', 'data_jurusans.nama_jurusan');

        // Filter berdasarkan kelas
        if ($request->filled('kelas')) {
            $rombels->where('data_kelas.id_kelas', $request->kelas);
        }
        
        // Filter berdasarkan jurusan (FITUR BARU)
        if ($request->filled('jurusan')) {
            if ($request->jurusan === 'null') {
                // Filter siswa yang belum punya jurusan
                $rombels->whereNull('rombels.id_jurusan');
            } else {
                $rombels->where('data_jurusans.id_jurusan', $request->jurusan);
            }
        }
        
        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $rombels->where(function($q) use ($search) {
                $q->where('data_siswas.nama_siswa', 'LIKE', "%{$search}%")
                ->orWhere('data_siswas.nis', 'LIKE', "%{$search}%")
                ->orWhere('data_kelas.nama_kelas', 'LIKE', "%{$search}%")
                ->orWhere('data_jurusans.nama_jurusan', 'LIKE', "%{$search}%");
            });
        }

        $rombels = $rombels->orderBy('nama_kelas','asc')->orderBy('nama_siswa','asc')->paginate(10)->withQueryString();

        return view('admin.rombel', compact('jurusan', 'kelas', 'siswa', 'allSiswa', 'rombels', 'siswaNoJurusan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:data_siswas,id_siswa',
            'id_kelas' => 'required|exists:data_kelas,id_kelas',
            'id_jurusan' => 'nullable|exists:data_jurusans,id_jurusan',
        ]);

        Rombel::create([
            'id_siswa'=> $request->id_siswa,
            'id_kelas'=> $request->id_kelas,
            'id_jurusan'=> $request->id_jurusan,
        ]);

        return redirect()->route('rombel.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Store multiple rombel at once
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:data_kelas,id_kelas',
            'id_jurusan' => 'nullable|exists:data_jurusans,id_jurusan',
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:data_siswas,id_siswa',
        ]);

        $inserted = 0;
        $skipped = 0;

        foreach ($request->siswa_ids as $siswa_id) {
            $exists = Rombel::where('id_siswa', $siswa_id)->exists();
            
            if (!$exists) {
                Rombel::create([
                    'id_siswa' => $siswa_id,
                    'id_kelas' => $request->id_kelas,
                    'id_jurusan' => $request->id_jurusan,
                ]);
                $inserted++;
            } else {
                $skipped++;
            }
        }

        $message = "$inserted siswa berhasil ditambahkan ke rombel.";
        if ($skipped > 0) {
            $message .= " $skipped siswa dilewati (sudah ada di rombel).";
        }

        return redirect()->route('rombel.index')->with(['success' => $message]);
    }

    /**
     * Tambah jurusan massal untuk siswa yang belum punya jurusan (FITUR BARU)
     */
    public function bulkAddJurusan(Request $request)
    {
        $request->validate([
            'id_jurusan' => 'required|exists:data_jurusans,id_jurusan',
            'rombel_ids' => 'required|array',
            'rombel_ids.*' => 'exists:rombels,id',
        ]);

        $updated = 0;

        foreach ($request->rombel_ids as $rombel_id) {
            $rombel = Rombel::find($rombel_id);
            
            // Pastikan hanya update yang belum punya jurusan
            if ($rombel && is_null($rombel->id_jurusan)) {
                $rombel->update([
                    'id_jurusan' => $request->id_jurusan,
                ]);
                $updated++;
            }
        }

        $message = "$updated siswa berhasil ditambahkan jurusan.";

        return redirect()->route('rombel.index')->with(['success' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rombel = Rombel::findOrFail($id);
        $siswa = DataSiswa::all();
        $kelas = DataKelas::all();
        $jurusan = DataJurusan::all();
        
        return response()->json([
            'rombel' => $rombel,
            'siswa' => $siswa,
            'kelas' => $kelas,
            'jurusan' => $jurusan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_siswa' => 'required|exists:data_siswas,id_siswa',
            'id_kelas' => 'required|exists:data_kelas,id_kelas',
            'id_jurusan' => 'nullable|exists:data_jurusans,id_jurusan',
        ]);

        $rombel = Rombel::findOrFail($id);
        
        $rombel->update([
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas,
            'id_jurusan' => $request->id_jurusan,
        ]);

        return redirect()->route('rombel.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        $rombels = Rombel::findOrFail($id);
        $rombels->delete();

        return redirect()->route('rombel.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}