<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
                <span class="text-4xl">📊</span>
                Laporan Data Perkelas
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Controls -->
            <div class="flex flex-col gap-6 mb-8">
                <!-- Semester Selection -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Pilih Semester:</span>
                    <div class="flex gap-3">
                        <a href="{{ route('user.perKelas', ['semester' => 1, 'kelas_filter' => request('kelas_filter')]) }}">
                            <button class="px-6 py-3 rounded-xl text-base font-semibold transition-all duration-200 {{ request('semester', 1) == 1 ? 'bg-blue-600 text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                Semester 1
                            </button>
                        </a>
                        <a href="{{ route('user.perKelas', ['semester' => 2, 'kelas_filter' => request('kelas_filter')]) }}">
                            <button class="px-6 py-3 rounded-xl text-base font-semibold transition-all duration-200 {{ request('semester') == 2 ? 'bg-blue-600 text-white shadow-lg' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                                Semester 2
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Class Filter and Export -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <span class="text-lg font-medium text-gray-700 dark:text-gray-300">Filter Kelas:</span>
                        <div class="relative">
                            <select id="kelasFilter" onchange="filterKelas()" class="appearance-none bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 py-3 px-4 pr-8 rounded-xl text-base font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 min-w-[200px]">
                                <option value="">Semua Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id_kelas }}" {{ request('kelas_filter') == $kls->id_kelas ? 'selected' : '' }}>
                                        {{ $kls->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        @if(request('kelas_filter'))
                            <a href="{{ route('user.perKelas', ['semester' => request('semester', 1)]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-medium transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                    
                    <form method="GET" action="{{ route('user.export.perKelas') }}" id="exportFormKelas">
                        <input type="hidden" name="semester" value="{{ request('semester', 1) }}">
                        <input type="hidden" name="kelas_filter" value="{{ request('kelas_filter', '') }}">
                        
                        <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-base font-semibold transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </button>
                    </form>
                </div>
            </div>

            @php
                $semester = request('semester', 1);
                $monthNums = $semester == 1 ? [7,8,9,10,11,12] : [1,2,3,4,5,6];
                $monthNames = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 
                    4 => 'April', 5 => 'Mei', 6 => 'Juni',
                    7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                    10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
            @endphp

            <!-- Summary Cards -->
            @php
                $totalSemester = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alfa' => 0];
                $filteredKelas = $kelas;
                
                // Filter kelas jika ada filter yang dipilih
                if(request('kelas_filter')) {
                    $filteredKelas = $kelas->where('id_kelas', request('kelas_filter'));
                }
                
                // Hitung total berdasarkan kelas yang difilter
                foreach($filteredKelas as $kls) {
                    if(isset($totalTahunan[$kls->id_kelas])) {
                        $data = $totalTahunan[$kls->id_kelas];
                        $totalSemester['hadir'] += $data['hadir'] ?? 0;
                        $totalSemester['izin'] += $data['izin'] ?? 0;
                        $totalSemester['sakit'] += $data['sakit'] ?? 0;
                        $totalSemester['alfa'] += $data['alfa'] ?? 0;
                    }
                }
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-base mb-1">Total Hadir</p>
                            <p class="text-3xl font-bold">{{ number_format($totalSemester['hadir']) }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <span class="text-2xl">✅</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-base mb-1">Total Izin</p>
                            <p class="text-3xl font-bold">{{ number_format($totalSemester['izin']) }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <span class="text-2xl">📝</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sky-100 text-base mb-1">Total Sakit</p>
                            <p class="text-3xl font-bold">{{ number_format($totalSemester['sakit']) }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <span class="text-2xl">🏥</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-red-100 text-base mb-1">Total Alfa</p>
                            <p class="text-3xl font-bold">{{ number_format($totalSemester['alfa']) }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <span class="text-2xl">❌</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class Cards -->
            <div class="space-y-8">
                @php $displayedKelas = request('kelas_filter') ? $kelas->where('id_kelas', request('kelas_filter')) : $kelas; @endphp
                @foreach ($displayedKelas as $index => $kls)
                    @php
                        $colors = [
                            ['from-blue-600', 'to-indigo-600', 'text-blue-100'],
                            ['from-purple-600', 'to-pink-600', 'text-purple-100'],
                            ['from-emerald-600', 'to-teal-600', 'text-emerald-100'],
                            ['from-orange-600', 'to-red-600', 'text-orange-100'],
                            ['from-cyan-600', 'to-blue-600', 'text-cyan-100'],
                        ];
                        $colorSet = $colors[$index % count($colors)];
                    @endphp

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r {{ $colorSet[0] }} {{ $colorSet[1] }} px-8 py-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center bg-white/20 text-white font-bold text-xl">
                                        {{ Str::limit($kls->nama_kelas, 2, '') }}
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-white">{{ $kls->nama_kelas }}</h3>
                                    </div>
                                </div>
                                
                                <!-- Year Total -->
                                @php $total = $totalTahunan[$kls->id_kelas] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0]; @endphp
                                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                                    <p class="{{ $colorSet[2] }} text-sm mb-3">Total Semester {{ $semester }}</p>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <p class="text-emerald-300 font-bold text-lg">H: {{ $total['hadir'] }}</p>
                                            <p class="text-amber-300 font-bold text-lg">I: {{ $total['izin'] }}</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-sky-300 font-bold text-lg">S: {{ $total['sakit'] }}</p>
                                            <p class="text-red-300 font-bold text-lg">A: {{ $total['alfa'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($monthNums as $m)
                                    @php
                                        $data = $dataBulan[$kls->id_kelas][$m] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0];
                                    @endphp
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                                            {{ $monthNames[$m] }}
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between bg-white dark:bg-gray-800 px-4 py-3 rounded-lg shadow-sm border border-emerald-200 dark:border-emerald-800">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                                                    <span class="text-emerald-700 dark:text-emerald-300 font-medium text-lg">Hadir</span>
                                                </div>
                                                <span class="font-bold text-emerald-800 dark:text-emerald-200 text-xl">{{ $data['hadir'] }}</span>
                                            </div>
                                            
                                            <div class="flex items-center justify-between bg-white dark:bg-gray-800 px-4 py-3 rounded-lg shadow-sm border border-amber-200 dark:border-amber-800">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                                                    <span class="text-amber-700 dark:text-amber-300 font-medium text-lg">Izin</span>
                                                </div>
                                                <span class="font-bold text-amber-800 dark:text-amber-200 text-xl">{{ $data['izin'] }}</span>
                                            </div>
                                            
                                            <div class="flex items-center justify-between bg-white dark:bg-gray-800 px-4 py-3 rounded-lg shadow-sm border border-sky-200 dark:border-sky-800">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-sky-500 rounded-full"></div>
                                                    <span class="text-sky-700 dark:text-sky-300 font-medium text-lg">Sakit</span>
                                                </div>
                                                <span class="font-bold text-sky-800 dark:text-sky-200 text-xl">{{ $data['sakit'] }}</span>
                                            </div>
                                            
                                            <div class="flex items-center justify-between bg-white dark:bg-gray-800 px-4 py-3 rounded-lg shadow-sm border border-red-200 dark:border-red-800">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                                    <span class="text-red-700 dark:text-red-300 font-medium text-lg">Alfa</span>
                                                </div>
                                                <span class="font-bold text-red-800 dark:text-red-200 text-xl">{{ $data['alfa'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($displayedKelas->isEmpty())
                <div class="text-center py-16">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                        @if(request('kelas_filter'))
                            Kelas Tidak Ditemukan
                        @else
                            Tidak Ada Data
                        @endif
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">
                        @if(request('kelas_filter'))
                            Kelas yang dipilih tidak memiliki data untuk semester ini.
                        @else
                            Belum ada data kelas untuk semester ini.
                        @endif
                    </p>
                    @if(request('kelas_filter'))
                        <a href="{{ route('user.perKelas', ['semester' => request('semester', 1)]) }}" class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Tampilkan Semua Kelas
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Class Filter -->
    <script>
        function filterKelas() {
            const select = document.getElementById('kelasFilter');
            const selectedValue = select.value;
            const currentUrl = new URL(window.location);
            
            if (selectedValue) {
                currentUrl.searchParams.set('kelas_filter', selectedValue);
            } else {
                currentUrl.searchParams.delete('kelas_filter');
            }
            
            window.location.href = currentUrl.toString();
        }
    </script>
</x-app-layout>