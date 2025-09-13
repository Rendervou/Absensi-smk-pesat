<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semobold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Data Guru
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5" x-data="siswaModal()">
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
                                Nama Guru   
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
                    @foreach ($guru as $g)
                    <tr class="hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-bold shadow-md">
                                {{ $guru->firstItem() + $loop->index }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap flex items-center">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                {{ substr($g->name, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $g->name }}</h3>
                                {{-- Jika ada field lain, tambahkan di sini --}}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Edit & Delete button, sesuaikan route dan id -->
                                <form action="{{ route('guru.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors shadow-sm" title="Hapus Guru">
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
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-5 py-3 bg-gray-50 dark:bg-gray-800">
                {{ $guru->links() }}
            </div>
        </div>


    </section>    
</x-app-layout>