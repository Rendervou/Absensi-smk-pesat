<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Laporan Perbulan
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <!-- Filter -->
        <form method="GET" action="{{ route('admin.perBulan') }}" class="flex flex-col sm:flex-row gap-3 mb-5">
            <select name="kelas"
                class="w-full sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id_kelas }}" {{ ($id_kelas ?? '') == $k->id_kelas ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>

            <select name="bulan"
                class="w-full sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ ($bulan ?? now()->month) == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endfor
            </select>

            <button type="submit"
                class="px-4 py-2 bg-orange-500 text-white rounded-lg shadow hover:bg-orange-600 transition">
                Cari
            </button>
        </form>

        <!-- Tabel Rekap -->
        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-900 shadow-sm">
            <table class="w-full">
                <!-- Table Header -->
                <thead class="bg-white dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">NIS</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">Kompetensi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b">S</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b">I</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider border-b">A</th>
                    </tr>
                </thead>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                    @forelse ($rekap as $nis => $r)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                                    {{ $loop->iteration }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $nis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $r['nama_siswa'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $r['kompetensi'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $r['S'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $r['I'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">{{ $r['A'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data presensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
