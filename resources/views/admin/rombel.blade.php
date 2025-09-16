<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rombel') }}
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="justify-between flex items-center mb-4  gap-5 ">
            
            <form action="{{route('rombel.index')}}" method="get" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-5">
                <input id="searchInput" name="search" class="w- bg-gray-50 border border-gray-300 text-gray-900 rounded-lg" type="text" placeholder="Cari Nama Siswa"">
            <select id="kelas" name="kelas"
                class="w-full sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                {{$k->nama_kelas}}
                @endforeach
            </select>
            <button type="submit" class="bg-orange-500 w-full sm:w-36 py-2.5 sm:py-2 rounded-lg text-white font-medium hover:bg-orange-600 transition-colors">
                Cari
            </button>
        </form>
            <div x-data="{ openRombel: false }">

                <!-- Tombol buka modal -->
                <button @click="openRombel = true"
                    class="px-4 py-2 bg-blue-600  text-white rounded-lg shadow hover:bg-blue-700 transition">
                    + Tambah Rombel
                </button>

                <!-- Modal -->
                <div x-show="openRombel" x-cloak
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>

                    <div @click.away="openRombel = false"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">

                        <!-- Header -->
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Tambah Rombel
                            </h3>
                            <button @click="openRombel = false"
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                ✕
                            </button>
                        </div>

                        <!-- Form -->
                        <form action="{{route('rombel.store')}}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Siswa</label>
                                <select name="id_siswa" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Nama Siswa --</option>
                                    @foreach ($siswa as $item)

                                    <option value="{{$item->id_siswa}}">{{$item->nama_siswa}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                                <select name="id_kelas" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                    <option value="{{$item->id_kelas}}">{{$item->nama_kelas}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jurusan</label>
                                <select name="id_jurusan" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($jurusan as $item)
                                    <option value="{{$item->id_jurusan}}">{{$item->nama_jurusan}}</option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jurusan</label>
                                <input type="text" name="jurusan"
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div> --}}

                            <!-- Footer -->
                            <div class="flex justify-end gap-3 pt-4 border-t">
                                <button type="button" @click="openRombel = false"
                                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- table --}}

        <div class="p-2">
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-900 shadow-sm">
                <table id="Table" class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-white dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">#</span>
                                    No.
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    Nama Siswa
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Kelas
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Jurusan
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-200 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    @foreach ($rombels as $item)
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">{{ $rombels->firstItem() + $loop->index }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    {{-- <div
                                        class="w-10 h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                        AF
                                    </div> --}}
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-200">{{$item->nama_siswa}}</div>
                                        {{-- <div class="text-sm text-gray-500">Jurusan : </div> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    {{$item->nama_kelas}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    {{$item->nama_jurusan}}
                                    
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                    @endforeach
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-6">
                {{ $rombels->links('pagination::tailwind') }}
            </div>
    </section>
    
</x-app-layout>
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#Table tbody tr');

    rows.forEach((row) => {
        const cells = row.querySelectorAll('td');
        let found = false;

        for (let i = 1; i < cells.length - 1; i++) {
            if (cells[i].textContent.toLowerCase().includes(searchValue)) {
                found = true;
                break;
            }
        }

        row.style.display = found ? '' : 'none';
    });
});

</script>