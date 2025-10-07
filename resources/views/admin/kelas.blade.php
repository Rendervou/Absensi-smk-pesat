<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Data Kelas') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Kelola data kelas dengan mudah
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <button class="p-3 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-2xl hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"></path>
                        </svg>
                    </button>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-ping"></div>
                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-600 rounded-full"></div>
                </div>
                
                <div class="flex items-center gap-4 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-3 shadow-lg border border-white/20 dark:border-gray-700/50 hover:shadow-xl transition-all duration-300">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-emerald-500 dark:text-emerald-400 font-semibold">Administrator</p>
                    </div>
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center transform hover:scale-110 transition-all duration-300 shadow-lg">
                            <span class="text-white font-black text-lg">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <div class="py-8 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 min-h-screen relative overflow-x-hidden">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-pink-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-emerald-400/10 to-cyan-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <section x-data="kelasData()">
                
                <!-- Alert Messages -->
                @if(session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-init="setTimeout(() => show = false, 3000)"
                     class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg shadow-lg animate-fade-in-up"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div x-data="{ show: true }" 
                     x-show="show"
                     class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-lg animate-fade-in-up">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold">Terjadi Kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="flex justify-between items-center mb-5 animate-fade-in-up">
                    <button @click="openAddModal = true"
                        class="group flex items-center gap-3 text-white bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-bold rounded-2xl text-sm px-6 py-3.5 text-center dark:focus:ring-blue-800 transition-all duration-500 transform hover:scale-105 shadow-2xl hover:shadow-blue-500/25 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <i class="fas fa-plus text-sm group-hover:rotate-12 transition-transform duration-300 relative z-10"></i>
                        <span class="relative z-10">Tambah Kelas</span>
                    </button>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                        <div class="px-6 py-6 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 border-b border-indigo-200/30 dark:border-gray-600/50">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-school text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">Data Kelas</h3>
                                        <p class="text-gray-600 dark:text-gray-300">Daftar semua kelas yang terdaftar</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-6 font-bold">
                                            <div class="flex items-center gap-2">
                                                No.
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-6 font-bold">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-chalkboard text-lg text-indigo-500"></i>
                                                Kelas
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-6 text-center font-bold">
                                            <div class="flex items-center justify-center gap-2">
                                                <i class="fas fa-cogs text-lg text-purple-500"></i>
                                                Aksi
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                    @forelse ($kelas as $k)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group">
                                        <td class="px-6 py-6">
                                            <div class="flex items-center">
                                                <span class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-black shadow-md">{{$loop->iteration}}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                                    {{ substr($k->nama_kelas, 0, 2) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-black text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">{{$k->nama_kelas}}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <button
                                                    @click="openEdit({{ $k->id_kelas }}, '{{ $k->nama_kelas }}')"
                                                    class="p-3 bg-blue-50/50 hover:bg-blue-100/50 rounded-xl text-blue-600 hover:text-blue-800 transition-colors duration-300 shadow-md transform hover:scale-110"
                                                    title="Edit Kelas">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                <form action="{{ route('kelas.destroy', $k->id_kelas) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-3 bg-red-50/50 hover:bg-red-100/50 rounded-xl text-red-600 hover:text-red-800 transition-colors duration-300 shadow-md transform hover:scale-110"
                                                        title="Hapus Kelas">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-4">
                                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                </svg>
                                                <div>
                                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Belum ada data kelas</h3>
                                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Silakan tambahkan kelas baru</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah Kelas -->
                <div x-show="openAddModal" 
                     x-cloak
                     class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                     style="background-color: rgba(0, 0, 0, 0.5);"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.escape.window="openAddModal = false">
                    <div @click.away="openAddModal = false"
                         class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md p-6 relative"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90">
                        
                        <!-- Close Button -->
                        <button @click="openAddModal = false" 
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-plus text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-black text-gray-800 dark:text-gray-100">Tambah Kelas Baru</h3>
                        </div>

                        <form action="{{route('kelas.store')}}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-chalkboard text-indigo-500 mr-1"></i>
                                    Nama Kelas
                                </label>
                                <input type="text" name="nama_kelas" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                                    placeholder="Contoh: X-1, XI-RPL, XII-TKJ">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Minimal 2 karakter
                                </p>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" @click="openAddModal = false"
                                    class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-2xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit Kelas -->
                <div x-show="openEditModal" 
                     x-cloak
                     class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                     style="background-color: rgba(0, 0, 0, 0.5);"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.escape.window="openEditModal = false">
                    <div @click.away="openEditModal = false"
                         class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md p-6 relative"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90">
                        
                        <!-- Close Button -->
                        <button @click="openEditModal = false" 
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-edit text-white text-lg"></i>
                            </div>
                            <h2 class="text-xl font-black text-gray-800 dark:text-white">Edit Data Kelas</h2>
                        </div>

                        <form :action="`{{ route('kelas.update', '') }}/${editId}`" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-chalkboard text-indigo-500 mr-1"></i>
                                    Nama Kelas
                                </label>
                                <input type="text" name="nama_kelas" x-model="editNama" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                    placeholder="Contoh: X-1, XI-RPL, XII-TKJ">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Minimal 2 karakter
                                </p>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" @click="openEditModal = false"
                                    class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-2xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
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