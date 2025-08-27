<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Data Siswa
        </h2>
    </x-slot>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="flex justify-between items-center mb-5">
            <div x-data="{ openSiswa: false }">

                <!-- Tombol buka modal -->
                <button @click="openSiswa = true"
                    class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Siswa
                </button>

                <!-- Modal -->
                <div x-show="openSiswa" x-cloak
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>

                    <div @click.away="openSiswa = false"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">

                        <!-- Header -->
                        <div class="flex justify-between items-center border-b pb-3 mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Tambah Siswa Baru
                            </h3>
                            <button @click="openSiswa = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl">
                                ✕
                            </button>
                        </div>

                        <!-- Form -->
                        <form action="{{route('siswa.store')}}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                    Siswa</label>
                                <input type="text" name="nama_siswa" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Masukkan nama siswa">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIS
                                </label>
                                <input type="number" name="nis" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Masukkan NIS">
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-end gap-3 pt-4 border-t">
                                <button type="button" @click="openSiswa = false"
                                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition shadow-md">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-900 shadow-lg">
            <table class="w-full">
                <!-- Table Header -->
                <thead class="bg-white dark:bg-gray-800 from-blue-50 to-indigo-50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b">
                            <div class="flex items-center gap-2">
                                <span
                                    class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">#</span>
                                No.
                            </div>
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>

                                Nama Siswa
                            </div>
                        </th>
                        <th
                            class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
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
                @foreach ($siswa as $s)
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span
                                    class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">{{
                                    $siswa->firstItem() + $loop->index }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                    {{ substr($s->nama_siswa, 0, 2) }}
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900">{{$s->nama_siswa}}</h3>
                                    <div class="text-sm text-gray-500 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                        </svg>
                                        NIS: {{$s->nis}}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center justify-center gap-2">
                                <button
                                    class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg transition-colors shadow-sm"
                                    title="Edit Siswa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <form action="{{ route('siswa.destroy', $s->id_siswa) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors shadow-sm"
                                        title="Hapus Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                </tbody>
                @endforeach
            </table>
            <div class="px-5 py-3 bg-gray-50 dark:bg-gray-800">
                {{ $siswa->links() }}
            </div>
        </div>
    </section>
</x-app-layout>