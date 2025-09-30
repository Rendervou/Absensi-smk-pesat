<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Dashboard Absensi') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        {{ date('l, d F Y') }} • <span class="text-emerald-500">Selamat datang kembali</span> ✨
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="p-3 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"></path>
                        </svg>
                    </button>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></div>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-600 rounded-full"></div>
                </div>
                
                <div class="flex items-center gap-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-3 shadow-lg border border-white/20 dark:border-gray-700/50 hover:shadow-xl transition-all duration-300">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-emerald-500 dark:text-emerald-400 font-semibold">Administrator</p>
                    </div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center transform hover:scale-110 transition-all duration-300 shadow-lg">
                            <span class="text-white font-black text-lg">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-8 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 min-h-screen relative overflow-hidden">
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-pink-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-emerald-400/10 to-cyan-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="mb-10 animate-fade-in-up">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 p-8 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 via-purple-500/5 to-pink-500/5 animate-gradient-x"></div>
                    
                    <div class="flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6 relative z-10">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="relative flex size-3">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-300 opacity-75"></span>
                                    <span class="relative inline-flex size-3 rounded-full bg-emerald-400"></span>
                                </span>
                                <span class="text-emerald-600 dark:text-emerald-400 font-semibold text-sm uppercase tracking-wider">Live Dashboard</span>
                            </div>
                            <h3 class="text-3xl font-black text-gray-800 dark:text-gray-100 mb-2">
                                Selamat datang {{ Auth::user()->name }}<span class="wave">👋</span>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
                                Kelola absensi siswa dengan <span class="font-bold text-indigo-600 dark:text-indigo-400">mudah</span> dan <span class="font-bold text-purple-600 dark:text-purple-400">efisien</span>
                            </p>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4 w-full xl:w-auto">
                            <a href="presensi" class="group">
                                <button type="button" class="flex items-center justify-center w-full sm:w-auto gap-3 text-white bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-bold rounded-2xl text-sm px-8 py-4 text-center dark:focus:ring-blue-800 transition-all duration-500 transform group-hover:scale-105 shadow-2xl hover:shadow-blue-500/25 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Absen Kehadiran
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            @php
                $totalSiswa = $totalSiswa ?? 0;
                $hadirPersen = $totalSiswa > 0 ? number_format(($hadir / $totalSiswa) * 100, 1) : 0;
                $izinPersen = $totalSiswa > 0 ? number_format(($izin / $totalSiswa) * 100, 1) : 0;
                $sakitPersen = $totalSiswa > 0 ? number_format(($sakit / $totalSiswa) * 100, 1) : 0;
                $alfaPersen = $totalSiswa > 0 ? number_format(($alfa / $totalSiswa) * 100, 1) : 0;
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
                <div class="stat-card-premium bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 text-white group animate-fade-in-up p-5" style="animation-delay: 0.1s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-slate-600 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-slate-500 rounded-full opacity-10 group-hover:opacity-30 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-2 h-2 bg-slate-400 rounded-full animate-pulse"></div>
                                    <p class="text-slate-300 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
                                </div>
                                <h2 class="text-5xl font-black mt-8 counter-number leading-none" data-target="{{ $totalSiswa }}">0</h2>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-r from-slate-600 via-slate-500 to-slate-700 rounded-3xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-card-premium bg-gradient-to-br from-emerald-600 via-emerald-500 to-green-600 text-white group animate-fade-in-up p-5" style="animation-delay: 0.2s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                    <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-emerald-300 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></div>
                                    <p class="text-emerald-100 text-xs font-bold uppercase tracking-wider">Hadir Hari Ini</p>
                                </div>
                                <h2 class="text-5xl font-black mb-1 counter-number leading-none" data-target="{{ $hadir }}">0</h2>
                            </div>
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 animate-pulse">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-1 bg-white/20 rounded-full h-3 overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-white via-emerald-200 to-white h-full rounded-full progress-bar shadow-sm" style="--progress-width: {{ $hadirPersen }}%;"></div>
                            </div>
                            <span class="text-xs text-emerald-100 ml-4 font-bold">{{ $hadirPersen }}%</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card-premium bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-600 text-white group animate-fade-in-up p-5" style="animation-delay: 0.3s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                    <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-cyan-300 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-2 h-2 bg-blue-300 rounded-full animate-pulse"></div>
                                    <p class="text-blue-100 text-xs font-bold uppercase tracking-wider">Izin</p>
                                </div>
                                <h2 class="text-5xl font-black mb-1 counter-number leading-none" data-target="{{ $izin }}">0</h2>
                            </div>
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-1 bg-white/20 rounded-full h-3 overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-white via-blue-200 to-white h-full rounded-full progress-bar shadow-sm" style="--progress-width: {{ $izinPersen }}%;"></div>
                            </div>
                            <span class="text-xs text-blue-100 ml-4 font-bold">{{ $izinPersen }}%</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card-premium bg-gradient-to-br from-orange-500 via-orange-600 to-red-500 text-white group animate-fade-in-up p-5" style="animation-delay: 0.4s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-orange-300 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                    <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-red-300 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-2 h-2 bg-orange-300 rounded-full animate-pulse"></div>
                                    <p class="text-orange-100 text-xs font-bold uppercase tracking-wider">Sakit</p>
                                </div>
                                <h2 class="text-5xl font-black mb-1 counter-number leading-none" data-target="{{ $sakit }}">0</h2>
                            </div>
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 animate-pulse">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-1 bg-white/20 rounded-full h-3 overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-white via-orange-200 to-white h-full rounded-full progress-bar shadow-sm" style="--progress-width: {{ $sakitPersen }}%;"></div>
                            </div>
                            <span class="text-xs text-orange-100 ml-4 font-bold">{{ $sakitPersen }}%</span>
                        </div>
                    </div>
                </div>

                <div class="stat-card-premium bg-gradient-to-br from-red-600 via-red-500 to-pink-600 text-white group animate-fade-in-up p-5" style="animation-delay: 0.5s;">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 bg-red-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"></div>
                    <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-pink-300 rounded-full opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-2 h-2 bg-red-300 rounded-full animate-pulse"></div>
                                    <p class="text-red-100 text-xs font-bold uppercase tracking-wider">Tanpa Keterangan</p>
                                </div>
                                <h2 class="text-5xl font-black mb-1 counter-number leading-none" data-target="{{ $alfa }}">0</h2>
                            </div>
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex-1 bg-white/20 rounded-full h-3 overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-white via-red-200 to-white h-full rounded-full progress-bar shadow-sm" style="--progress-width: {{ $alfaPersen }}%;"></div>
                            </div>
                            <span class="text-xs text-red-100 ml-4 font-bold">{{ $alfaPersen }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 overflow-hidden relative">
                    
                    <div class="px-8 py-6 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 border-b border-indigo-200/30 dark:border-gray-600/50">
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-chart-line text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">Data Kehadiran Terkini</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Update real-time kehadiran siswa</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="relative group">
                                    <input type="text" placeholder="Cari siswa..." class="w-64 bg-white/50 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-2xl px-4 py-3 pl-12 text-gray-700 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300 backdrop-blur-sm">
                                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-300"></i>
                                </div>
                                <button class="p-3 bg-white/50 dark:bg-gray-700/50 hover:bg-white dark:hover:bg-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-filter"></i>
                                </button>
                                <button class="p-3 bg-white/50 dark:bg-gray-700/50 hover:bg-white dark:hover:bg-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                <tr>
                                    <th scope="col" class="px-8 py-6 font-bold">
                                        <div class="flex items-center gap-2">
                                            Nama Siswa
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 opacity-50 hover:opacity-100 cursor-pointer transition-opacity duration-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-6 font-bold">NIS</th>
                                    <th scope="col" class="px-6 py-6 font-bold">Kehadiran</th>
                                    <th scope="col" class="px-6 py-6 font-bold">Guru</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @forelse($latestPresensi as $row)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="relative">
                                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center flex-shrink-0 transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                                                        <span class="text-white text-sm font-black">
                                                            {{ strtoupper(substr($row->nama_siswa, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></div>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900 dark:text-white text-lg group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">{{ $row->nama_siswa }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                                        Kelas {{ $row->kelas->nama_kelas ?? '-' }} • {{ $row->nama_jurusan }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-gray-800 dark:text-gray-200 font-mono font-bold text-lg">
                                            {{ $row->siswa->nis ?? '-' }}
                                        </td>
                                        <td class="px-6 py-6">
                                            @if($row->status == 'hadir')
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700 shadow-lg">
                                                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                                    Hadir
                                                </span>
                                            @elseif($row->status == 'sakit')
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300 border border-orange-200 dark:border-orange-700 shadow-lg">
                                                    <span class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></span>
                                                    Sakit
                                                </span>
                                            @elseif($row->status == 'izin')
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-700 shadow-lg">
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                                                    Izin
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 border border-red-200 dark:border-red-700 shadow-lg">
                                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                                    Alfa
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-6 text-gray-600 dark:text-gray-400 font-semibold">
                                            {{ $row->nama_guru }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-16 text-center">
                                            <div class="flex flex-col items-center gap-4">
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-500 dark:text-gray-400 mb-1">Belum ada data</h4>
                                                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada data absensi hari ini</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-8 py-6 bg-gradient-to-r from-gray-50/50 to-gray-100/50 dark:from-gray-800/50 dark:to-gray-700/50 border-t border-gray-200/50 dark:border-gray-600/50">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Menampilkan <span class="font-bold text-indigo-600 dark:text-indigo-400">1-10</span> dari <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($totalSiswa) }}</span> siswa
                            </div>
                            <div class="flex items-center space-x-1">
                                {{ $latestPresensi->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-8 right-8 z-50">
            <div class="relative group">
                <button class="w-16 h-16 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 rounded-full shadow-2xl flex items-center justify-center text-white transform hover:scale-110 transition-all duration-300 animate-pulse">
                    <i class="fas fa-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                </button>
                <div class="absolute bottom-full right-0 mb-2 px-3 py-2 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                    Aksi Cepat
                    <div class="absolute top-full right-4 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }
        
        .stat-card-premium {
            @apply p-8 rounded-3xl shadow-2xl backdrop-blur-sm border border-white/30 transition-all duration-500 transform hover:scale-105 hover:shadow-3xl relative overflow-hidden;
            backdrop-filter: blur(20px);
            border-radius: 24px !important;
        }
        
        .counter-number {
            font-family: 'Inter', sans-serif;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.02em;
        }
        
        .progress-bar {
            animation: progressFill 2s ease-in-out;
        }
        
        .wave {
            animation: wave 2s infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
        
        @keyframes wave {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
        
        @keyframes fade-in-up {
            from { 
                opacity: 0; 
                transform: translateY(50px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        @keyframes progressFill {
            from { width: 0%; }
            to { width: var(--progress-width); }
        }
        
        @keyframes gradient-x {
            0%, 100% {
                background-size: 200% 200%;
                background-position: left center;
            }
            50% {
                background-size: 200% 200%;
                background-position: right center;
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .animate-gradient-x {
            animation: gradient-x 6s ease infinite;
        }
        
        /* Enhanced hover effects */
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
        
        .group:hover .group-hover\:rotate-12 {
            transform: rotate(12deg);
        }
        
        .group:hover .group-hover\:-translate-y-1 {
            transform: translateY(-4px);
        }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(156, 163, 175, 0.1);
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #4f46e5, #7c3aed, #db2777);
        }
        
        /* Enhanced shadow utilities */
        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Responsive improvements */
        @media (max-width: 640px) {
            .counter-number {
                font-size: 2.5rem;
            }
            
            .stat-card-enhanced {
                padding: 1.5rem;
            }
        }
        
        /* Dark mode enhancements */
        .dark .stat-card-enhanced {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        /* Counter animation */
        .counter-number {
            transition: all 0.3s ease;
        }
        
        /* Loading animation for counters */
        @keyframes countUp {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .counter-number {
            animation: countUp 0.6s ease-out;
        }
        
        /* Improved button animations */
        button {
            position: relative;
            overflow: hidden;
        }
        
        button:hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
            left: 100%;
        }
        
        /* Enhanced table row animations */
        tbody tr {
            animation: slideInUp 0.3s ease-out;
        }
        
        tbody tr:nth-child(even) {
            animation-delay: 0.1s;
        }
        
        tbody tr:nth-child(odd) {
            animation-delay: 0.2s;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter animation
            const counters = document.querySelectorAll('.counter-number');
            
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-target'));
                    const start = 0;
                    const duration = 2000;
                    const startTime = performance.now();
                    
                    const animate = (currentTime) => {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        
                        // Easing function
                        const easeOutCubic = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(start + (target - start) * easeOutCubic);
                        
                        counter.textContent = current.toLocaleString();
                        
                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            counter.textContent = target.toLocaleString();
                        }
                    };
                    
                    requestAnimationFrame(animate);
                });
            };
            
            // Start animation when page loads
            setTimeout(animateCounters, 500);
            
            // Progress bars animation
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach((bar, index) => {
                setTimeout(() => {
                    bar.style.animation = `progressFill 1.5s ease-in-out forwards`;
                }, 200 * (index + 1));
            });
            
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Enhanced search functionality
            const searchInput = document.querySelector('input[placeholder="Cari siswa..."]');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const tableRows = document.querySelectorAll('tbody tr');
                    
                    tableRows.forEach(row => {
                        const studentName = row.querySelector('td:first-child')?.textContent.toLowerCase();
                        const nis = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase();
                        
                        if (studentName?.includes(searchTerm) || nis?.includes(searchTerm)) {
                            row.style.display = '';
                            row.style.animation = 'slideInUp 0.3s ease-out';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
        
        // Add ripple effect CSS
        const style = document.createElement('style');
        style.textContent = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                pointer-events: none;
                transform: scale(0);
                animation: ripple 0.6s linear;
                z-index: 1;
            }
            
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>