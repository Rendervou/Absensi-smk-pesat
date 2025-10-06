<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.perBulan') }}" class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        Detail Presensi Siswa
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Bulan {{ $namaBulan[$bulan] }} {{ $tahun }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <section class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen p-6">
        <div class="max-w-7xl mx-auto space-y-6">
            
            
            <!-- Tombol Kembali di Header -->
            <button onclick="window.history.back()" 
                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-semibold">Kembali</span>
            </button>
            <!-- Card Info Siswa -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Siswa
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold text-3xl">
                                    {{ strtoupper(substr($siswa->nama_siswa, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">NIS</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $siswa->nis }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Nama</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $siswa->nama_siswa }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Kelas</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $rombel->nama_kelas ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase">Jurusan</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $rombel->nama_jurusan ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-gray-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Total</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $statistik['total'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Hadir</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-1">{{ $statistik['hadir'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">H</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Sakit</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $statistik['sakit'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">S</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Izin</p>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-1">{{ $statistik['izin'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">I</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase">Alpa</p>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-1">{{ $statistik['alfa'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xl">A</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Status -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter Status</h3>
                    </div>
                    
                    <form method="GET" action="{{ route('admin.detailSiswa', $siswa->nis) }}" class="flex flex-wrap items-center gap-3">
                        <!-- Hidden inputs untuk mempertahankan bulan dan tahun -->
                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">
                        
                        <!-- Filter Status -->
                        <select name="status" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="alfa" {{ request('status') == 'alfa' ? 'selected' : '' }}>Alpa</option>
                        </select>
                        
                        <!-- Tombol Filter -->
                        <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <span class="font-semibold">Terapkan</span>
                        </button>
                        
                        <!-- Tombol Reset (hanya tampil jika ada filter aktif) -->
                        @if(request('status'))
                        <a href="{{ route('admin.detailSiswa', ['nis' => $siswa->nis, 'bulan' => $bulan, 'tahun' => $tahun]) }}" 
                            class="px-6 py-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="font-semibold">Reset</span>
                        </a>
                        @endif
                    </form>
                </div>
                
                <!-- Info Filter Aktif -->
                @if(request('status'))
                <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-blue-700 dark:text-blue-300">
                            Menampilkan data dengan status: 
                            <span class="font-bold">{{ ucfirst(request('status')) }}</span>
                        </span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Tabel Detail Presensi -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Riwayat Presensi Harian
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Hari</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase">Waktu Absen</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                            @forelse ($detailPresensi as $presensi)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg flex items-center justify-center text-sm font-bold">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($presensi->tanggal)->format('d F Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($presensi->tanggal)->locale('id')->isoFormat('dddd') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($presensi->status == 'hadir')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Hadir
                                            </span>
                                        @elseif($presensi->status == 'sakit')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                                Sakit
                                            </span>
                                        @elseif($presensi->status == 'izin')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                                Izin
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Alpa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($presensi->created_at)->format('H:i') }} WIB
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center space-y-4">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada data</h3>
                                                <p class="text-gray-500 dark:text-gray-400">Siswa belum memiliki riwayat presensi</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($detailPresensi->count() > 0)
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Total <span class="font-semibold">{{ $detailPresensi->count() }}</span> hari presensi
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Persentase Kehadiran: 
                            <span class="font-bold text-green-600">
                                {{ $statistik['total'] > 0 ? number_format(($statistik['hadir'] / $statistik['total']) * 100, 1) : 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>