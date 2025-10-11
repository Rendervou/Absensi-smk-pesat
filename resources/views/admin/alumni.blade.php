<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-amber-600 via-orange-600 to-yellow-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Daftar Alumni') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Data siswa yang telah lulus
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-8 bg-gradient-to-br from-amber-50 via-white to-orange-50 dark:from-gray-900 dark:via-gray-800 dark:to-amber-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-2xl shadow-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-emerald-400 text-xl mr-3"></i>
                    <p class="text-emerald-800 font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-2xl shadow-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl mr-3"></i>
                    <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Filter -->
            <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-6 mb-6">
                <h3 class="text-xl font-black text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <i class="fas fa-filter text-amber-500"></i>
                    Filter & Pencarian Alumni
                </h3>
                <form method="GET" action="{{ route('admin.alumni.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-search mr-1"></i>Cari Nama/NIS
                        </label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Nama atau NIS..." 
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-1"></i>Tahun Lulus
                        </label>
                        <select name="tahun" class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                            <option value="">-- Semua Tahun --</option>
                            @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-school mr-1"></i>Kelas Terakhir
                        </label>
                        <input 
                            type="text" 
                            name="kelas" 
                            value="{{ request('kelas') }}" 
                            placeholder="Contoh: XII-RPL" 
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 text-white py-3 px-6 rounded-2xl font-bold hover:from-amber-700 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                    <div class="flex items-end">
                        <a href="{{ route('admin.alumni.index') }}" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 py-3 px-6 rounded-2xl font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 text-center">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </a>
                    </div>
                </form>
                
                <!-- Info Pencarian Aktif -->
                @if(request('search') || request('tahun') || request('kelas'))
                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                    <div class="flex items-center gap-2 text-sm">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400"></i>
                        <span class="text-blue-800 dark:text-blue-300 font-semibold">Filter aktif:</span>
                        @if(request('search'))
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-semibold">
                            Pencarian: "{{ request('search') }}"
                        </span>
                        @endif
                        @if(request('tahun'))
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-semibold">
                            Tahun: {{ request('tahun') }}
                        </span>
                        @endif
                        @if(request('kelas'))
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-semibold">
                            Kelas: {{ request('kelas') }}
                        </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Tabel Alumni -->
            <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                <div class="px-6 py-6 bg-gradient-to-r from-amber-500/10 via-orange-500/10 to-yellow-500/10 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">Data Alumni</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                @if(request('search') || request('tahun') || request('kelas'))
                                    Hasil pencarian: <span class="font-bold text-amber-600">{{ $alumni->total() }}</span> alumni ditemukan
                                @else
                                    Total: <span class="font-bold text-amber-600">{{ $alumni->total() }}</span> alumni
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4">No.</th>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">NIS</th>
                                <th class="px-6 py-4">Kelas Terakhir</th>
                                <th class="px-6 py-4">Jurusan</th>
                                <th class="px-6 py-4">Tahun Lulus</th>
                                <th class="px-6 py-4">Tanggal Kelulusan</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($alumni as $index => $alum)
                            <tr class="hover:bg-amber-50/50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $alumni->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                            {{ substr($alum->nama_siswa, 0, 2) }}
                                        </div>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $alum->nama_siswa }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $alum->nis }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-semibold">{{ $alum->nama_kelas_terakhir }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $alum->nama_jurusan ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $alum->tahun_lulus }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($alum->tanggal_kelulusan)->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.alumni.hapus', $alum->id_alumni) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alumni ini dan mengembalikan status siswa ke aktif?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 hover:bg-red-100 rounded-lg text-red-600 hover:text-red-800 transition-colors" title="Hapus & Kembalikan ke Siswa Aktif">
                                            <i class="fas fa-undo text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-user-graduate text-3xl text-gray-400"></i>
                                        </div>
                                        @if(request('search') || request('tahun') || request('kelas'))
                                        <p class="text-gray-500 dark:text-gray-400 font-semibold mb-2">Tidak ada alumni yang ditemukan</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
                                        @else
                                        <p class="text-gray-500 dark:text-gray-400 font-semibold">Tidak ada data alumni</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-6 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    {{ $alumni->links() }}
                </div>
            </div>

        </div>
    </div>

    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }
        
        [x-cloak] { 
            display: none !important; 
        }
    </style>

    <script>
        function checkSiswaLulus() {
            const container = document.getElementById('siswaListContainer');
            container.innerHTML = '<p class="text-gray-500"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data...</p>';
            
            // Show the result box
            this.showCleanup = true;
            
            // Fetch data from API
            fetch('/admin/kelulusan/check-siswa-lulus')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.siswaCount = data.count;
                        
                        if (data.count > 0) {
                            let html = '<ul class="space-y-2 mt-2">';
                            data.data.forEach((siswa, index) => {
                                const statusBadge = siswa.sudah_alumni === 'Ya' 
                                    ? '<span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Sudah di Alumni</span>'
                                    : '<span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">Belum di Alumni</span>';
                                
                                html += `
                                    <li class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <span class="font-medium text-gray-700 dark:text-gray-200">
                                            ${index + 1}. ${siswa.nama} (NIS: ${siswa.nis})
                                        </span>
                                        ${statusBadge}
                                    </li>
                                `;
                            });
                            html += '</ul>';
                            container.innerHTML = html;
                        } else {
                            container.innerHTML = '<p class="text-green-600 dark:text-green-400"><i class="fas fa-check-circle mr-2"></i>Tidak ada siswa dengan status lulus di database siswa. Data sudah bersih!</p>';
                        }
                    } else {
                        container.innerHTML = `<p class="text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>Error: ${data.message}</p>`;
                    }
                })
                .catch(error => {
                    container.innerHTML = `<p class="text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>Gagal memuat data: ${error.message}</p>`;
                });
        }
    </script>
</x-app-layout>