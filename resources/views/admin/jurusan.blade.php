<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-emerald-600 via-teal-600 to-green-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Data Jurusan') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Kelola informasi jurusan secara terperinci
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
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
    
    <div class="py-8 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 min-h-screen">
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-pink-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500 rounded-lg animate-fade-in-up">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-emerald-500 text-xl mr-3"></i>
                    <p class="text-emerald-700 dark:text-emerald-400 font-semibold">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg animate-fade-in-up">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                    <p class="text-red-700 dark:text-red-400 font-semibold">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg animate-fade-in-up">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3 mt-1"></i>
                    <div>
                        <p class="text-red-700 dark:text-red-400 font-semibold mb-2">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-red-600 dark:text-red-400">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <section x-data="jurusanData()">
                <div class="flex justify-between items-center mb-5 animate-fade-in-up">
                    <button @click="openAddModal()"
                        class="group flex items-center gap-3 text-white bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-700 hover:from-emerald-700 hover:via-emerald-800 hover:to-teal-800 focus:outline-none focus:ring-4 focus:ring-emerald-300 font-bold rounded-2xl text-sm px-6 py-3.5 text-center dark:focus:ring-emerald-800 transition-all duration-500 transform hover:scale-105 shadow-2xl hover:shadow-emerald-500/25 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4 group-hover:rotate-90 transition-transform duration-300 relative z-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span class="relative z-10">Tambah Jurusan</span>
                    </button>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                        <div class="px-6 py-6 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 border-b border-indigo-200/30 dark:border-gray-600/50">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-chart-bar text-white text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">Data Jurusan</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Daftar semua jurusan yang terdaftar</p>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-bold">
                                            <div class="flex items-center gap-2">
                                                No.
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 font-bold">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-building text-lg text-indigo-500"></i>
                                                Nama Jurusan
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-center font-bold">
                                            <div class="flex items-center justify-center gap-2">
                                                <i class="fas fa-cogs text-lg text-purple-500"></i>
                                                Aksi
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @forelse ($jurusan as $k)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <span class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-black shadow-md">{{ $loop->iteration }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                                    {{ strtoupper(substr($k->nama_jurusan, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-black text-gray-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300">{{ $k->nama_jurusan }}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <button
                                                    @click="openEditModal({{ $k->id_jurusan }}, '{{ addslashes($k->nama_jurusan) }}')"
                                                    class="p-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/40 rounded-xl text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-all duration-300 shadow-md transform hover:scale-110"
                                                    title="Edit jurusan">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                <form action="{{ route('jurusan.destroy', $k->id_jurusan) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan {{ addslashes($k->nama_jurusan) }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-3 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 rounded-xl text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 transition-all duration-300 shadow-md transform hover:scale-110"
                                                        title="Hapus jurusan">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-inbox text-gray-300 dark:text-gray-600 text-5xl mb-4"></i>
                                                <p class="text-gray-500 dark:text-gray-400 font-semibold">Belum ada data jurusan</p>
                                                <p class="text-gray-400 dark:text-gray-500 text-sm">Klik tombol "Tambah Jurusan" untuk menambahkan data</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Tambah Jurusan -->
                <div x-show="showAddModal" x-cloak
                     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-[9999]"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div @click.away="closeAddModal()"
                         class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md relative border border-gray-200 dark:border-gray-700"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-plus text-white"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-gray-800 dark:text-gray-100">Tambah Jurusan Baru</h3>
                                </div>
                                <button @click="closeAddModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                            <form action="{{ route('jurusan.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-building text-emerald-500 mr-2"></i>Nama Jurusan
                                    </label>
                                    <input type="text" name="nama_jurusan" required
                                        class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                        placeholder="Contoh: Teknik Komputer dan Jaringan">
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                                    <button type="button" @click="closeAddModal()"
                                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-2xl text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl font-bold hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 shadow-lg hover:shadow-emerald-500/50 transform hover:scale-105">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Jurusan -->
                <div x-show="showEditModal" x-cloak
                     class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 z-[9999]"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div @click.away="closeEditModal()"
                         class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md relative border border-gray-200 dark:border-gray-700"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-edit text-white"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-gray-800 dark:text-gray-100">Edit Data Jurusan</h3>
                                </div>
                                <button @click="closeEditModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                            <form :action="'{{ url('admin/jurusan') }}/' + editId" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-building text-blue-500 mr-2"></i>Nama Jurusan
                                    </label>
                                    <input type="text" name="nama_jurusan" x-model="editNama" required
                                        class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Masukkan nama jurusan">
                                </div>
                                <div class="flex justify-end gap-3 pt-4 border-t dark:border-gray-700">
                                    <button type="button" @click="closeEditModal()"
                                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-2xl text-gray-700 dark:text-gray-300 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-times mr-2"></i>Batal
                                    </button>
                                    <button type="submit"
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-bold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/50 transform hover:scale-105">
                                        <i class="fas fa-save mr-2"></i>Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }

        [x-cloak] { 
            display: none !important; 
        }

        /* PERBAIKAN: Prevent horizontal & vertical overflow */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        body {
            position: relative;
        }
        
        @keyframes fade-in-up {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }
        
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-track {
            background: rgba(156, 163, 175, 0.1);
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #6366f1, #8b5cf6, #ec4899);
            border-radius: 10px;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #4f46e5, #7c3aed, #db2777);
        }
    </style>

    <script>
        function jurusanData() {
            return {
                showAddModal: false,
                showEditModal: false,
                editId: null,
                editNama: '',

                openAddModal() {
                    this.showAddModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeAddModal() {
                    this.showAddModal = false;
                    document.body.style.overflow = 'auto';
                },

                openEditModal(id, nama) {
                    this.editId = id;
                    this.editNama = nama;
                    this.showEditModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeEditModal() {
                    this.showEditModal = false;
                    this.editId = null;
                    this.editNama = '';
                    document.body.style.overflow = 'auto';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[class*="bg-emerald-50"], [class*="bg-red-50"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
</x-app-layout>