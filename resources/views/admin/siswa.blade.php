<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Data Siswa
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5" x-data="siswaModal()">

        <!-- Tombol Tambah -->
        <div class="flex justify-between items-center mb-5" x-data="{ openAdd: false }">
            <button @click="openAdd = true"
                class="flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Siswa
            </button>
            <div x-show="openAdd" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            x-transition>
            <div @click.away="openAdd = false"
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Tambah Siswa Baru</h3>
                <form action="{{ route('siswa.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300">Nama Siswa</label>
                        <input type="text" name="nama_siswa" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-gray-300">NIS</label>
                        <input type="number" name="nis" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="openAdd = false"
                            class="px-4 py-2 border rounded-lg text-gray-600 dark:text-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-900 shadow-lg">
            <table class="w-full">
                <!-- Header -->
                <thead class="bg-white dark:bg-gray-800">
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
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.5 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
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
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0..." />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Aksi
                            </div>
                        </th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                    @foreach ($siswa as $s)
                    <tr class="hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">
                                {{ $siswa->firstItem() + $loop->index }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                {{ substr($s->nama_siswa, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $s->nama_siswa }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">NIS: {{ $s->nis }}</p>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center justify-center gap-2">
                                <div x-data="{
                                    openEdit: false,
                                    editId: null,
                                    editNama: '',
                                    editNis: '',
                                    setEditData(id, nama, nis) {
                                        this.editId = id;
                                        this.editNama = nama;
                                        this.editNis = nis;
                                        this.openEdit = true;
                                    }
                                }">
                                    <!-- Edit -->
                                    <button
                                        @click="openEdit = true; setEditData({{ $s->id_siswa }}, '{{ $s->nama_siswa }}', '{{ $s->nis }}')"
                                        class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-2 rounded-lg transition-colors shadow-sm"
                                        title="Edit Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5..." />
                                        </svg>
                                    </button>
                                    <div x-show="openEdit" x-cloak
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                                        x-transition>
                                        <div @click.away="openEdit = false"
                                            class="bg-white dark:bg-slate-900 rounded-lg shadow-lg w-full max-w-md p-6">
                                            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Edit
                                                Data
                                                Siswa</h2>
                                            <form :action="`{{ url('admin/siswa') }}/${editId}`" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 dark:text-gray-300">Nama</label>
                                                    <input type="text" name="nama_siswa" x-model="editNama"
                                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-gray-700 dark:text-gray-300">NIS</label>
                                                    <input type="text" name="nis" x-model="editNis"
                                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                </div>
                                                <div class="flex justify-end gap-3">
                                                    <button type="button" @click="openEdit = false"
                                                        class="px-4 py-2 border rounded-lg text-gray-600 dark:text-gray-300">Batal</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete -->
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 01..." />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-5 py-3 bg-gray-50 dark:bg-gray-800">
                {{ $siswa->links() }}
            </div>
        </div>


    </section>

    <!-- Alpine.js Script -->

</x-app-layout>