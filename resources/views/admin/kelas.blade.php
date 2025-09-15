<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            📊 Laporan Data Perkelas
        </h2>
    </x-slot>

    <section class="p-4 sm:p-6 bg-gray-50 dark:bg-gray-900 min-h-[70vh]">
        <!-- Controls -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div class="flex items-center gap-3">
                <div class="text-sm text-gray-500 dark:text-gray-300">Tampilkan:</div>
                <a href="{{ route('admin.perKelas', ['semester' => 1]) }}">
                    <button class="px-4 py-2 rounded-lg text-sm font-semibold transition
                        {{ request('semester', 1) == 1 ? 'bg-blue-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border' }}">
                        Semester 1
                    </button>
                </a>
                <a href="{{ route('admin.perKelas', ['semester' => 2]) }}">
                    <button class="px-4 py-2 rounded-lg text-sm font-semibold transition
                        {{ request('semester') == 2 ? 'bg-blue-600 text-white shadow' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border' }}">
                        Semester 2
                    </button>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <!-- Optional: tombol export (placeholder) -->
                <button class="px-3 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 shadow">Export CSV</button>
            </div>
        </div>

        {{-- Desktop table --}}
        <div class="hidden lg:block overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow-lg">
            <table class="min-w-full text-base text-gray-900 dark:text-gray-200">
                <thead class="sticky top-0 z-20 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">No</th>
                        <th class="px-6 py-4 text-left font-semibold">Nama Kelas</th>

                        @php
                            $semester = request('semester', 1);
                            $monthNums = $semester == 1 ? [7,8,9,10,11,12] : [1,2,3,4,5,6];
                        @endphp

                        @foreach ($monthNums as $m)
                            <th class="px-4 py-3 text-center font-semibold text-sm">{{ \Carbon\Carbon::create()->month($m)->format('M') }}</th>
                        @endforeach

                        <th class="px-6 py-3 text-center font-semibold">TOTAL (1 Tahun)</th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @php $no = 1; @endphp
                    @foreach ($kelas as $kls)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                            <td class="px-6 py-4 font-bold align-middle">{{ $no++ }}</td>

                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-indigo-500 text-white font-semibold">
                                        {{ Str::limit($kls->nama_kelas, 2, '') }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $kls->nama_kelas }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-400">ID: {{ $kls->id_kelas }}</div>
                                    </div>
                                </div>
                            </td>

                            @foreach ($monthNums as $m)
                                @php
                                    $data = $dataBulan[$kls->id_kelas][$m] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0];
                                @endphp
                                <td class="px-4 py-4 align-middle text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">H {{ $data['hadir'] }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">I {{ $data['izin'] }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-sky-100 text-sky-800">S {{ $data['sakit'] }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">A {{ $data['alfa'] }}</span>
                                    </div>
                                </td>
                            @endforeach

                            @php $total = $totalTahunan[$kls->id_kelas] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0]; @endphp
                            <td class="px-6 py-4 align-middle text-center bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
                                <div class="inline-grid gap-1 text-sm font-semibold">
                                    <span class="text-green-600">H: {{ $total['hadir'] }}</span>
                                    <span class="text-yellow-500">I: {{ $total['izin'] }}</span>
                                    <span class="text-sky-600">S: {{ $total['sakit'] }}</span>
                                    <span class="text-red-600">A: {{ $total['alfa'] }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile: cards --}}
        <div class="lg:hidden space-y-4">
            @foreach ($kelas as $kls)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-indigo-500 text-white font-semibold">
                                {{ Str::limit($kls->nama_kelas, 2, '') }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $kls->nama_kelas }}</div>
                                <div class="text-xs text-gray-400">{{ $kls->id_kelas }}</div>
                            </div>
                        </div>

                        @php $total = $totalTahunan[$kls->id_kelas] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0]; @endphp
                        <div class="text-right text-sm font-semibold">
                            <div class="text-green-600">H: {{ $total['hadir'] }}</div>
                            <div class="text-yellow-500">I: {{ $total['izin'] }}</div>
                            <div class="text-sky-600">S: {{ $total['sakit'] }}</div>
                            <div class="text-red-600">A: {{ $total['alfa'] }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($monthNums as $m)
                            @php
                                $data = $dataBulan[$kls->id_kelas][$m] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alfa'=>0];
                            @endphp
                            <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg border border-gray-100 dark:border-gray-700">
                                <div class="text-xs text-gray-500 mb-1">{{ \Carbon\Carbon::create()->month($m)->format('M') }}</div>
                                <div class="flex flex-col gap-1">
                                    <span class="text-green-600 text-sm font-semibold">H: {{ $data['hadir'] }}</span>
                                    <span class="text-yellow-500 text-sm font-semibold">I: {{ $data['izin'] }}</span>
                                    <span class="text-sky-600 text-sm font-semibold">S: {{ $data['sakit'] }}</span>
                                    <span class="text-red-600 text-sm font-semibold">A: {{ $data['alfa'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-app-layout>
