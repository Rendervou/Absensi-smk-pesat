<?php
    namespace App\Http\Controllers;

    use App\Models\DataJurusan;
    use App\Models\DataKelas;
    use App\Models\DataSiswa;
    use App\Models\Presensi;
    use App\Models\Rombel;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;

    class UserPresensiController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index(Request $request)
        {
            $siswa = DataSiswa::all();
            $kelas = DataKelas::all();
            $jurusan = DataJurusan::all();
            $presensi = Presensi::all();
            $rombels = Rombel::join('data_kelas', 'data_kelas.id_kelas', '=', 'rombels.id_kelas')
            ->join('data_siswas', 'data_siswas.id_siswa', '=', 'rombels.id_siswa')
            ->join('data_jurusans', 'data_jurusans.id_jurusan', '=', 'rombels.id_jurusan')
                ->select('data_siswas.*', 'data_kelas.*', 'data_jurusans.*');

            if ($request->filled('kelas')) {
                $rombels->where('data_kelas.id_kelas', $request->kelas);
            };

            $rombels = $rombels->orderBy('data_siswas.nama_siswa','asc')->paginate(50);
            
            return view('user.absensi', compact('presensi', 'rombels', 'siswa', 'kelas', 'jurusan'));   

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
            $id_siswa = $request->input('id_siswa', []);
            $id_kelas = $request->input('id_kelas', []);
            $tanggal  = now()->toDateString();
            $guru     = auth()->user();

            foreach ($id_siswa as $index => $siswaId) {
                $kelasId = $id_kelas[$index];
                $siswa   = DataSiswa::find($siswaId);
                $kelas   = DataKelas::find($kelasId);

                $status = $request->input("kehadiran_{$siswaId}", 'hadir');

                Presensi::updateOrCreate(
                    [
                        'id_siswa' => $siswa->id_siswa,
                        'tanggal'  => $tanggal,
                    ],
                    [
                        'id_siswa'    => $siswa->id_siswa,
                        'id_kelas'    => $kelasId, // ← langsung pakai $kelasId biar pasti masuk
                        'id_user'     => $guru->id,
                        'nama_siswa'  => $siswa->nama_siswa,
                        'nama_kelas'  => $kelas ? $kelas->nama_kelas : null,
                        'nama_jurusan'=> $kelas && $kelas->jurusan ? $kelas->jurusan->nama_jurusan : null,
                        'nama_guru'   => $guru->name,
                        'status'      => $status,
                        'tanggal'     => $tanggal,
                    ]
                );
            }

            return redirect()->route('user.presensi.index')
                ->with('success', 'Presensi berhasil disimpan / diperbarui.');
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
