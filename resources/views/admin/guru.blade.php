<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
                <span class="text-4xl">🧑‍🏫</span>
                Data Guru
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-base mb-1">Total Guru</p>
                            {{-- Ganti dengan variabel total guru Anda --}}
                            <p class="text-3xl font-bold">{{ $guru->count() }}</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <span class="text-2xl">👨‍🏫</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                        <div class="relative w-full sm:w-80">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchInput" placeholder="Cari Nama Guru..."
                                class="bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg block w-full pl-10 p-2.5 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($guru as $g)
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-300 hover:shadow-lg hover:border-blue-500">
                            <div class="flex flex-col items-center text-center">
                                <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white font-bold text-xl mb-4 shadow-md">
                                    {{ substr($g->name, 0, 2) }}
                                </div>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $g->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">NIP: {{ $g->nip ?? 'Belum ada' }}</p>
                                <div class="flex items-center justify-center gap-2 mt-4">
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('guru.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors shadow-sm" title="Hapus Guru">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex justify-center">
                        {{ $guru->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const searchTerm = this.value.toLowerCase();
                    const teacherCards = document.querySelectorAll('.grid > div');
                    
                    teacherCards.forEach(card => {
                        const teacherName = card.querySelector('h4')?.textContent.toLowerCase();
                        const nip = card.querySelector('p')?.textContent.toLowerCase();
                        
                        if (teacherName?.includes(searchTerm) || nip?.includes(searchTerm)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</x-app-layout>