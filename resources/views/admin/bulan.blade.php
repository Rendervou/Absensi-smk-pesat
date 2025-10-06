<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
                <svg class="w-8 h-8 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Laporan Perbulan
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ now()->format('d F Y') }}
            </div>
        </div>
    </x-slot>

    <section class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen p-3 sm:p-6">
        <!-- Enhanced Filter Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                    Filter & Pencarian Data
                </h3>
            </div>
            
            <div class="p-6">
                <form method="GET" action="{{ route('admin.perBulan') }}" class="space-y-6">
                    <!-- Search Bar -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pencarian (Nama, NIS, atau Kelas)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama siswa, NIS, atau kelas..."
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:text-white transition duration-150 ease-in-out">
                        </div>
                    </div>

                    <!-- Filter Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Kelas Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kelas
                            </label>
                            <select name="kelas"
                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-3 transition duration-150 ease-in-out">
                                <option value="">Semua Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id_kelas }}" {{ ($id_kelas ?? '') == $k->id_kelas ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Bulan Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Bulan
                            </label>
                            <select name="bulan"
                                class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-3 transition duration-150 ease-in-out">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ ($bulan ?? now()->month) == $m ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-end justify-end gap-4">
                            <button type="submit"
                                class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-200 ease-in-out">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Data
                            </button>
                            <a href="{{ route('admin.perBulan') }}" 
                                class="flex items-center justify-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition duration-200 ease-in-out ">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        @if(isset($rekap) && count($rekap) > 0)
        @php
            $totalSiswa = count($rekap);
            $totalHadir = array_sum(array_column($rekap, 'H'));
            $totalSakit = array_sum(array_column($rekap, 'S'));
            $totalIzin = array_sum(array_column($rekap, 'I'));
            $totalAlpa = array_sum(array_column($rekap, 'A'));
            $totalKehadiran = $totalHadir + $totalSakit + $totalIzin + $totalAlpa;
            
            // Hitung persentase
            $persenHadir = $totalKehadiran > 0 ? round(($totalHadir / $totalKehadiran) * 100, 1) : 0;
            $persenSakit = $totalKehadiran > 0 ? round(($totalSakit / $totalKehadiran) * 100, 1) : 0;
            $persenIzin = $totalKehadiran > 0 ? round(($totalIzin / $totalKehadiran) * 100, 1) : 0;
            $persenAlpa = $totalKehadiran > 0 ? round(($totalAlpa / $totalKehadiran) * 100, 1) : 0;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <!-- Total Siswa Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-gray-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Siswa</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalSiswa }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Hadir Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">H</span>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Hadir</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalHadir }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ $persenHadir }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Sakit Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">S</span>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sakit</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalSakit }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $persenSakit }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Izin Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">I</span>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Izin</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalIzin }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    {{ $persenIzin }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Alpa Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div class="flex items-center flex-1">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-lg">A</span>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Alpa</p>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalAlpa }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    {{ $persenAlpa }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Enhanced Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Data Presensi Siswa Bulan {{ DateTime::createFromFormat('!m', $bulan ?? now()->month)->format('F') }}
                    </h3>
                    <!-- Ganti button export yang lama dengan form ini -->
                    @if(isset($rekap) && count($rekap) > 0)
                    <form method="GET" action="{{ route('admin.export.perBulan') }}" id="exportForm">
                        <input type="hidden" name="bulan" value="{{ $bulan ?? now()->month }}">
                        <input type="hidden" name="kelas" value="{{ $id_kelas ?? '' }}">
                        <input type="hidden" name="jurusan" value="{{ $selected_jurusan ?? '' }}">
                        <input type="hidden" name="search" value="{{ $search ?? '' }}">
                        
                        <button type="submit" class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-1">
                                    <span>No</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a.997.997 0 01-.707.293H7a4 4 0 01-4-4V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <span>NIS</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Nama Siswa</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>Kompetensi</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-center space-x-1">
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">H</span>
                                    </div>
                                    <span>Hadir</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-center space-x-1">
                                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">S</span>
                                    </div>
                                    <span>Sakit</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-center space-x-1">
                                    <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">I</span>
                                    </div>
                                    <span>Izin</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-center space-x-1">
                                    <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">A</span>
                                    </div>
                                    <span>Alpa</span>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse ($rekap as $nis => $r)
                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-200 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl flex items-center justify-center text-sm font-bold shadow-md group-hover:shadow-lg transition-shadow duration-200">
                                            {{ $loop->iteration }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg">
                                            {{ $nis }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">
                                                    {{ strtoupper(substr($r['nama_siswa'], 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $r['nama_siswa'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $r['kompetensi'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium {{ $r['H'] > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $r['H'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium {{ $r['S'] > 0 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $r['S'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium {{ $r['I'] > 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $r['I'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-medium {{ $r['A'] > 0 ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-gray-100 text-gray-500 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $r['A'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <a href="{{ route('admin.detailSiswa', ['nis' => $nis, 'bulan' => $bulan]) }}" 
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white text-xs font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div class="text-center">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada data presensi</h3>
                                            <p class="text-gray-500 dark:text-gray-400">Coba ubah filter pencarian atau pilih bulan yang berbeda.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer with Pagination Info -->
            @if(isset($rekap) && count($rekap) > 0)
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Menampilkan <span class="font-semibold">{{ count($rekap) }}</span> data siswa
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <script>
        function exportData() {
            // Add export functionality here
            alert('Fitur export akan segera tersedia!');
        }
    </script>
</x-app-layout>