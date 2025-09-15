<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-slate-800 to-slate-900 -m-6 p-6 mb-6">
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                {{ __('Laporan Per Semester') }}
            </h2>
            <p class="text-slate-300 mt-2">Analisis statistik kehadiran siswa per semester</p>
        </div>
    </x-slot>

    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filter Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Ajaran</label>
                        <select class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                            <option value="2023">2023</option>
                            <option value="2024" selected>2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Semester</label>
                        <select class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                            <option value="1" selected>Semester 1 (Ganjil)</option>
                            <option value="2">Semester 2 (Genap)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                        <select class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors duration-200">
                            <option value="all" selected>Semua Kelas</option>
                            <option value="X-1">X-1</option>
                            <option value="X-2">X-2</option>
                            <option value="XI-1">XI-1</option>
                            <option value="XI-2">XI-2</option>
                            <option value="XII-1">XII-1</option>
                            <option value="XII-2">XII-2</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            Filter Data
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Total Hari Sekolah</p>
                            <p class="text-3xl font-bold text-slate-800">120</p>
                            <p class="text-green-600 text-sm font-medium mt-1">Hari</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-slate-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Rata-rata Kehadiran</p>
                            <p class="text-3xl font-bold text-blue-600">85.2%</p>
                            <p class="text-green-600 text-sm font-medium mt-1">↑ 2.3% dari semester lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Total Siswa</p>
                            <p class="text-3xl font-bold text-orange-600">308</p>
                            <p class="text-slate-600 text-sm font-medium mt-1">Siswa aktif</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-orange-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-slate-200 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Tingkat Absensi</p>
                            <p class="text-3xl font-bold text-red-600">14.8%</p>
                            <p class="text-red-600 text-sm font-medium mt-1">↓ 1.2% dari semester lalu</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-red-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 12M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Grafik Kehadiran Semester Ganjil 2024 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Grafik Kehadiran Siswa Januari 2024</h3>
                            <p class="text-slate-500 text-sm">Persentase kehadiran per kelas</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-xs text-slate-600">Juli/1/2024-5</span>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="chart1"></canvas>
                    </div>
                </div>

                <!-- Grafik Kehadiran Siswa Februari 2024 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Grafik Kehadiran Siswa Februari 2024</h3>
                            <p class="text-slate-500 text-sm">Persentase kehadiran per kelas</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                            <span class="text-xs text-slate-600">Agustus/4/2024-5</span>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="chart2"></canvas>
                    </div>
                </div>

                <!-- Grafik Kehadiran Siswa Maret 2024 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Grafik Kehadiran Siswa Maret 2024</h3>
                            <p class="text-slate-500 text-sm">Persentase kehadiran per kelas</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-xs text-slate-600">Sep-26-5</span>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="chart3"></canvas>
                    </div>
                </div>

                <!-- Grafik Kehadiran Siswa April 2024 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Grafik Kehadiran Siswa April 2024</h3>
                            <p class="text-slate-500 text-sm">Persentase kehadiran per kelas</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                            <span class="text-xs text-slate-600">Okt/2024-5</span>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="chart4"></canvas>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-200">
                <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-white">Detail Statistik Per Kelas</h3>
                            <p class="text-slate-300 text-sm">Ringkasan kehadiran semester ganjil 2024</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Export Excel
                            </button>
                            <button class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.32 0H6.34m11.32 0l1.07-6.001" />
                                </svg>
                                Print
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left font-semibold text-slate-700">Kelas</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-slate-700">Total Siswa</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-slate-700">Hadir (%)</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-slate-700">Izin (%)</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-slate-700">Sakit (%)</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-slate-700">Alfa (%)</th>
                                <th scope="col" class="px-6 py-4 text-center font-semibold text-slate-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach([
                                ['X-1', 32, 87.5, 8.2, 3.1, 1.2, 'Baik'],
                                ['X-2', 30, 85.3, 9.1, 4.2, 1.4, 'Baik'],
                                ['XI-1', 28, 89.2, 7.5, 2.8, 0.5, 'Sangat Baik'],
                                ['XI-2', 29, 82.1, 11.2, 5.1, 1.6, 'Cukup'],
                                ['XII-1', 31, 91.8, 5.2, 2.1, 0.9, 'Sangat Baik'],
                                ['XII-2', 33, 88.7, 7.8, 2.9, 0.6, 'Baik']
                            ] as $row)
                            <tr class="hover:bg-slate-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                            {{ $row[0] }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-900">Kelas {{ $row[0] }}</p>
                                            <p class="text-xs text-slate-500">{{ $row[1] }} siswa</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-slate-700">{{ $row[1] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $row[2] }}%"></div>
                                        </div>
                                        <span class="font-semibold text-green-700">{{ $row[2] }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-orange-600">{{ $row[3] }}%</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-blue-600">{{ $row[4] }}%</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-semibold text-red-600">{{ $row[5] }}%</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($row[6] === 'Sangat Baik')
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            {{ $row[6] }}
                                        </span>
                                    @elseif($row[6] === 'Baik')
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            {{ $row[6] }}
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                            {{ $row[6] }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

    <script>
        // Data untuk chart sesuai dengan gambar
        const chartData = {
            labels: ['GUGUR', 'GUGUR', 'GUGUR', 'X1-1', 'X1-2', 'X1-3', 'XI-IPA', 'XI-IPA', 'XII-IPA', 'XII-IPS'],
            datasets: []
        };

        // Konfigurasi chart yang konsisten
        const chartConfig = {
            type: 'line',
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1,
                        ticks: {
                            stepSize: 0.1,
                            callback: function(value) {
                                return value.toFixed(1);
                            }
                        },
                        grid: {
                            color: '#e2e8f0'
                        }
                    },
                    x: {
                        grid: {
                            color: '#e2e8f0'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'rect',
                            padding: 20
                        }
                    }
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    },
                    line: {
                        tension: 0.1
                    }
                }
            }
        };

        // Chart 1 - Januari 2024
        const ctx1 = document.getElementById('chart1').getContext('2d');
        new Chart(ctx1, {
            ...chartConfig,
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Juli/1/2024-5',
                        data: [0.9, 0.85, 0.88, 0.92, 0.87, 0.89, 0.91, 0.86, 0.93, 0.88],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        pointBackgroundColor: '#3b82f6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Juli/1/2024-1',
                        data: [0.88, 0.82, 0.85, 0.89, 0.84, 0.87, 0.88, 0.83, 0.9, 0.85],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Juli/1/2024-4',
                        data: [0.85, 0.87, 0.83, 0.91, 0.88, 0.86, 0.89, 0.85, 0.92, 0.87],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }
                ]
            }
        });

        // Chart 3 - Maret 2024
        const ctx3 = document.getElementById('chart3').getContext('2d');
        new Chart(ctx3, {
            ...chartConfig,
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Sep-26-5',
                        data: [0.91, 0.87, 0.89, 0.93, 0.88, 0.9, 0.92, 0.87, 0.94, 0.89],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Sep-26-1',
                        data: [0.88, 0.84, 0.86, 0.9, 0.85, 0.87, 0.89, 0.84, 0.91, 0.86],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        pointBackgroundColor: '#ef4444',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Sep-26-4',
                        data: [0.86, 0.88, 0.84, 0.92, 0.89, 0.87, 0.9, 0.86, 0.93, 0.88],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }
                ]
            }
        });

        // Chart 4 - April 2024
        const ctx4 = document.getElementById('chart4').getContext('2d');
        new Chart(ctx4, {
            ...chartConfig,
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Okt/2024-5',
                        data: [0.93, 0.89, 0.91, 0.95, 0.9, 0.92, 0.94, 0.89, 0.96, 0.91],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Okt/2024-1',
                        data: [0.9, 0.86, 0.88, 0.92, 0.87, 0.89, 0.91, 0.86, 0.93, 0.88],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Okt/2024-4',
                        data: [0.88, 0.9, 0.86, 0.94, 0.91, 0.89, 0.92, 0.88, 0.95, 0.9],
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }
                ]
            }
        });

        // Animate charts on load
        window.addEventListener('load', function() {
            const charts = document.querySelectorAll('canvas');
            charts.forEach((chart, index) => {
                chart.style.opacity = '0';
                chart.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    chart.style.transition = 'all 0.6s ease-out';
                    chart.style.opacity = '1';
                    chart.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Filter functionality
        const filterSelects = document.querySelectorAll('select');
        const filterButton = document.querySelector('button[type="button"]');
        
        filterButton.addEventListener('click', function() {
            // Add loading state
            this.innerHTML = `
                <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memfilter...
            `;
            
            // Simulate filtering delay
            setTimeout(() => {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    Filter Data
                `;
                
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full opacity-0 transition-all duration-300';
                successMsg.innerHTML = `
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Data berhasil difilter!
                    </div>
                `;
                document.body.appendChild(successMsg);
                
                setTimeout(() => {
                    successMsg.classList.remove('translate-x-full', 'opacity-0');
                }, 100);
                
                setTimeout(() => {
                    successMsg.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => successMsg.remove(), 300);
                }, 3000);
            }, 1500);
        });
    </script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Custom scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #f97316, #ea580c);
            border-radius: 3px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #ea580c, #c2410c);
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            .print-break {
                page-break-before: always;
            }
            
            body {
                -webkit-print-color-adjust: exact;
            }
        }
        
        /* Mobile chart responsiveness */
        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
            }
        }
        
        /* Loading animation */
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        /* Progress bar animation */
        .progress-bar {
            animation: progressFill 1.5s ease-out;
        }
        
        @keyframes progressFill {
            from {
                width: 0;
            }
        }
    </style>
</x-app-layout>

        // Chart 2 - Februari 2024
        const ctx2 = document.getElementById('chart2').getContext('2d');
        new Chart(ctx2, {
            ...chartConfig,
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Agustus/4/2024-5',
                        data: [0.92, 0.88, 0.9, 0.94, 0.89, 0.91, 0.93, 0.88, 0.95, 0.9],
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        pointBackgroundColor: '#f97316',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Agustus/4/2024-1',
                        data: [0.89, 0.85, 0.87, 0.91, 0.86, 0.88, 0.9, 0.85, 0.92, 0.87],
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        pointBackgroundColor: '#06b6d4',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Agustus/4/2024-4',
                        data: [0.87, 0.89, 0.85, 0.93, 0.9, 0.88, 0.91, 0.87, 0.94, 0.89],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        pointBackgroundColor: '#8b5cf6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2