<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Import Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 animate-fade-in">
                    
                    
                    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 rounded-lg">
                        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                            
                            <!-- Tombol Absen -->
                                <a href="siswabaru">
                                <button type="button" 
                                    class="flex items-center justify-center w-full sm:w-auto gap-3 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all duration-300 transform hover:scale-105">
                                    Absen Kehadiran
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </a>

                            <!-- Statistik Cards -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mt-6 sm:rounded-lg">
                                <div class="stat-card bg-gradient-to-br from-gray-800 to-gray-900 text-white">
                                    <p class="text-sm opacity-75">Total Siswa</p>
                                    <h2 class="number">308</h2>
                                </div>
                                <div class="stat-card bg-gradient-to-br from-blue-500 to-blue-700 text-white">
                                    <p class="text-sm opacity-75">Total Hadir Hari Ini</p>
                                    <h2 class="number">240</h2>
                                </div>
                                <div class="stat-card bg-gradient-to-br from-green-500 to-green-700 text-white">
                                    <p class="text-sm opacity-75">Izin</p>
                                    <h2 class="number">2</h2>
                                </div>
                                <div class="stat-card bg-gradient-to-br from-red-500 to-red-700 text-white">
                                    <p class="text-sm opacity-75">Sakit</p>
                                    <h2 class="number">11</h2>
                                </div>
                                <div class="stat-card bg-gradient-to-br from-black to-gray-800 text-white">
                                    <p class="text-sm opacity-75">Tanpa Keterangan</p>
                                    <h2 class="number">0</h2>
                                </div>
                            </div>

                            <!-- Tabel -->
                            <div class="relative overflow-x-auto mt-6 rounded-lg border border-gray-200 dark:border-gray-700">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Nama</th>
                                            <th scope="col" class="px-6 py-3">NIS</th>
                                            <th scope="col" class="px-6 py-3">Kehadiran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach([['Daffa Rafif Ramadhan','0185354558','Hadir'],['Daffa Rafif Ramadhan','0185354558','Hadir'],['Daffa Rafif Ramadhan','0185354558','Hadir'],['Daffa Rafif Ramadhan','0185354558','Juga']] as $row)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $row[0] }}</th>
                                            <td class="px-6 py-4">{{ $row[1] }}</td>
                                            <td class="px-6 py-4">{{ $row[2] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Style -->
    <style>
        .stat-card {
            @apply p-5 rounded-xl shadow-md flex flex-col gap-1 transition-all duration-300 transform hover:scale-105;
        }
        .stat-card .number {
            font-size: 2rem;
            font-family: 'Anton', sans-serif;
            line-height: 1;
        }
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-in-out;
        }
    </style>
</x-app-layout>
