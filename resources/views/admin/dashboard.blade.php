<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard Absensi') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ date('l, d F Y') }} • Selamat datang kembali
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Administrator</p>
                </div>
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Quick Actions Header -->
            <div class="mb-8">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Aksi Cepat</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Kelola absensi siswa dengan mudah</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <a href="presensi" class="group">
                                <button type="button" 
                                    class="flex items-center justify-center w-full sm:w-auto gap-3 text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-6 py-3 text-center dark:focus:ring-blue-800 transition-all duration-300 transform group-hover:scale-105 shadow-lg hover:shadow-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Absen Kehadiran
                                </button>
                            </a>
                            <button type="button" 
                                class="flex items-center justify-center w-full sm:w-auto gap-3 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-xl text-sm px-6 py-3 border border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600 transition-all duration-300 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Export Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="stat-card bg-gradient-to-br from-slate-700 via-slate-800 to-slate-900 text-white group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-75 mb-1">Total Siswa</p>
                            <h2 class="number">{{ number_format($totalSiswa) }}</h2>
                        </div>
                        <div class="p-3 bg-white/10 rounded-lg group-hover:bg-white/20 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs opacity-60">100% dari target</div>
                </div>

                <div class="stat-card bg-gradient-to-br from-emerald-500 via-emerald-600 to-emerald-700 text-white group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-75 mb-1">Hadir Hari Ini</p>
                            <h2 class="number">240</h2>
                        </div>
                        <div class="p-3 bg-white/10 rounded-lg group-hover:bg-white/20 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs opacity-60">77.9% kehadiran</div>
                </div>

                <div class="stat-card bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 text-white group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-75 mb-1">Izin</p>
                            <h2 class="number">2</h2>
                        </div>
                        <div class="p-3 bg-white/10 rounded-lg group-hover:bg-white/20 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs opacity-60">0.6% dari total</div>
                </div>

                <div class="stat-card bg-gradient-to-br from-amber-500 via-orange-600 to-red-600 text-white group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-75 mb-1">Sakit</p>
                            <h2 class="number">11</h2>
                        </div>
                        <div class="p-3 bg-white/10 rounded-lg group-hover:bg-white/20 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs opacity-60">3.6% dari total</div>
                </div>

                <div class="stat-card bg-gradient-to-br from-red-600 via-red-700 to-red-800 text-white group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-75 mb-1">Tanpa Keterangan</p>
                            <h2 class="number">55</h2>
                        </div>
                        <div class="p-3 bg-white/10 rounded-lg group-hover:bg-white/20 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs opacity-60">17.9% dari total</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Tabel Data Kehadiran -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <div>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Data Kehadiran Terkini</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Update real-time kehadiran siswa</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-lg transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                                        </svg>
                                    </button>
                                    <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-lg transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-medium">
                                            <div class="flex items-center gap-2">
                                                Nama Siswa
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 opacity-50">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 font-medium">NIS</th>
                                        <th scope="col" class="px-6 py-4 font-medium">Kehadiran</th>
                                        <th scope="col" class="px-6 py-4 font-medium">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach([
                                        ['Daffa Rafif Ramadhan','018535455','Hadir','07:15'],
                                        ['Aisyah Putri Nabila','018535456','Hadir','07:20'],
                                        ['Muhammad Rizky Pratama','018535457','Sakit','--'],
                                        ['Siti Nurhaliza Rahman','018535458','Hadir','07:10'],
                                        ['Ahmad Fajar Sidiq','018535459','Izin','--']
                                    ] as $index => $row)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <span class="text-white text-xs font-semibold">{{ substr($row[0], 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900 dark:text-white">{{ $row[0] }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Kelas XI IPA 1</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-gray-300 font-mono">{{ $row[1] }}</td>
                                        <td class="px-6 py-4">
                                            @if($row[2] == 'Hadir')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                                    {{ $row[2] }}
                                                </span>
                                            @elseif($row[2] == 'Sakit')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                                    {{ $row[2] }}
                                                </span>
                                            @elseif($row[2] == 'Izin')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                                                    {{ $row[2] }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                                    Alpha
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-mono">{{ $row[3] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span>Menampilkan 5 dari 308 siswa</span>
                                <button class="text-blue-600 hover:text-blue-800 font-medium">Lihat Semua →</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Stats -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    {{-- <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Ringkasan Minggu Ini</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Kehadiran</span>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-green-600">78.2%</div>
                                    <div class="text-xs text-green-500">↑ 2.1%</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Ketidakhadiran</span>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-red-600">21.8%</div>
                                    <div class="text-xs text-red-500">↓ 1.2%</div>
                                </div>
                            </div>
                            <div class="h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 w-3/4 rounded-full"></div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Recent Activity -->
                    {{-- <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 dark:border-gray-700/50 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Aktivitas Terkini</h3>
                        <div class="space-y-3">
                            @foreach([
                                ['Daffa melakukan absen masuk', '2 menit lalu', 'green'],
                                ['Aisyah mengajukan izin sakit', '5 menit lalu', 'yellow'],
                                ['Data absensi telah diperbarui', '10 menit lalu', 'blue'],
                                ['Rizky terlambat masuk sekolah', '15 menit lalu', 'red']
                            ] as $activity)
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-{{ $activity[2] }}-500 rounded-full mt-2 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm text-gray-800 dark:text-gray-200">{{ $activity[0] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity[1] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Styles -->
    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }
        
        .stat-card {
            @apply p-6 rounded-xl shadow-lg backdrop-blur-sm border border-white/20 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl;
            backdrop-filter: blur(10px);
        }
        
        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
            font-family: 'Inter', sans-serif;
        }
        
        @keyframes fade-in {
            from { 
                opacity: 0; 
                transform: translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .animate-slide-in {
            animation: slide-in 0.4s ease-out;
        }
        
        /* Glassmorphism effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Hover effects */
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-2px);
            shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        /* Responsive improvements */
        @media (max-width: 640px) {
            .stat-card .number {
                font-size: 2rem;
            }
        }
        
        /* Dark mode improvements */
        .dark .glass {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</x-app-layout>