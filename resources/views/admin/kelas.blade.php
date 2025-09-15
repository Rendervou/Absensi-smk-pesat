<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Absensi Kelas') }}
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-screen">
        <div class="w-full max-w-7xl mx-auto">
            
            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filter Laporan</h3>
                <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Kelas Filter -->
                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih Kelas</label>
                        <select id="kelas" name="kelas"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Semua Kelas</option>
                            <option value="10A">X-A</option>
                            <option value="10B">X-B</option>
                            <option value="11A">XI-A</option>
                            <option value="11B">XI-B</option>
                            <option value="12A">XII-A</option>
                            <option value="12B">XII-B</option>
                        </select>
                    </div>

                    <!-- Bulan Filter -->
                    <div>
                        <label for="bulan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                        <select id="bulan" name="bulan"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9" selected>September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>

                    <!-- Tahun Filter -->
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                        <select id="tahun" name="tahun"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="2024">2024</option>
                            <option value="2025" selected>2025</option>
                        </select>
                    </div>

                    <!-- Button Actions -->
                    <div class="flex flex-col gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>
                        <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Statistics -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Total Siswa</p>
                            <p class="text-2xl font-bold">32</p>
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Rata-rata Hadir</p>
                            <p class="text-2xl font-bold">94.2%</p>
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Total Izin/Sakit</p>
                            <p class="text-2xl font-bold">18</p>
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.382 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-500 to-red-700 text-white p-4 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Total Alpha</p>
                            <p class="text-2xl font-bold">5</p>
                        </div>
                        <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Laporan Absensi Kelas X-A - September 2025
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nama Siswa</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Hadir</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Sakit</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Izin</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Alpha</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Persentase</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                            $siswa_data = [
                                ['Ahmad Rizki Pratama', '001', 18, 1, 1, 0, 90.0],
                                ['Siti Nurhaliza', '002', 19, 0, 1, 0, 95.0],
                                ['Budi Santoso', '003', 17, 2, 0, 1, 85.0],
                                ['Dewi Sartika', '004', 20, 0, 0, 0, 100.0],
                                ['Andi Wijaya', '005', 16, 1, 2, 1, 80.0],
                                ['Maya Sari', '006', 19, 1, 0, 0, 95.0],
                                ['Rudi Hermawan', '007', 15, 0, 1, 4, 75.0],
                                ['Lina Marlina', '008', 20, 0, 0, 0, 100.0],
                            ];
                            @endphp

                            @foreach($siswa_data as $index => $siswa)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-sm font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-full flex items-center justify-center font-semibold text-sm">
                                            {{ substr($siswa[0], 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $siswa[0] }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">NIS: {{ $siswa[1] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        {{ $siswa[2] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                        {{ $siswa[3] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                        {{ $siswa[4] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                        {{ $siswa[5] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $siswa[6] }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($siswa[6] >= 90)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Baik
                                        </span>
                                    @elseif($siswa[6] >= 80)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Cukup
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Kurang
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile/Tablet Card View -->
            <div class="lg:hidden space-y-4">
                @foreach($siswa_data as $index => $siswa)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-4">
                    <!-- Student Header -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            {{ $index + 1 }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $siswa[0] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">NIS: {{ $siswa[1] }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $siswa[6] }}%</div>
                            @if($siswa[6] >= 90)
                                <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Baik</span>
                            @elseif($siswa[6] >= 80)
                                <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">Cukup</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Kurang</span>
                            @endif
                        </div>
                    </div>

                    <!-- Attendance Stats -->
                    <div class="grid grid-cols-4 gap-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <div class="text-sm font-medium text-green-600 dark:text-green-400">{{ $siswa[2] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Hadir</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-medium text-yellow-600 dark:text-yellow-400">{{ $siswa[3] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Sakit</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $siswa[4] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Izin</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-medium text-red-600 dark:text-red-400">{{ $siswa[5] }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Alpha</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">8</span> dari <span class="font-medium">32</span> siswa
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        Previous
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        1
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        2
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        Next
                    </button>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>