<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 via-cyan-600 to-indigo-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Data Siswa') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Kelola data siswa dengan mudah
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

    <!-- Kontainer utama tanpa overflow hidden untuk mencegah masalah z-index -->
    <div class="py-8 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 min-h-screen relative">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-pink-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-emerald-400/10 to-cyan-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 relative">
            <section x-data="siswaModal()">
                <div class="flex justify-between items-center mb-5 animate-fade-in-up">
                    <div x-data="{ openAdd: false }">
                        <button @click="openAdd = true"
                            class="group flex items-center gap-3 text-white bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-bold rounded-2xl text-sm px-6 py-3.5 text-center dark:focus:ring-blue-800 transition-all duration-500 transform group-hover:scale-105 shadow-2xl hover:shadow-blue-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-4 h-4 group-hover:rotate-12 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Siswa
                        </button>
                    </div>
                </div>

                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 relative">
                        <div class="px-8 py-6 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 border-b border-indigo-200/30 dark:border-gray-600/50">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-users text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">Data Siswa</h3>
                                        <p class="text-gray-600 dark:text-gray-300">Kelola informasi siswa secara terperinci</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="relative group">
                                        <input type="text" placeholder="Cari siswa..." class="w-64 bg-white/50 dark:bg-gray-700/50 border border-gray-300/50 dark:border-gray-600/50 rounded-2xl px-4 py-3 pl-12 text-gray-700 dark:text-gray-200 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all duration-300">
                                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                    <tr>
                                        <th scope="col" class="px-8 py-6 font-bold">
                                            <div class="flex items-center gap-2">
                                                No.
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-6 font-bold">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-user-circle text-lg text-indigo-500"></i>
                                                Nama Siswa
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
                                    @foreach ($siswa as $s)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center">
                                                <span class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-black shadow-md">{{ $siswa->firstItem() + $loop->index }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                                    {{ substr($s->nama_siswa, 0, 2) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-black text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">{{ $s->nama_siswa }}</h3>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">NIS: {{ $s->nis }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-sm font-medium">
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
                                                    <button
                                                        @click="setEditData({{ $s->id_siswa }}, '{{ $s->nama_siswa }}', '{{ $s->nis }}')"
                                                        class="p-3 bg-blue-50/50 hover:bg-blue-100/50 rounded-xl text-blue-600 hover:text-blue-800 transition-colors duration-300 shadow-md transform hover:scale-110">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </button>
                                                </div>
                                                <form action="{{ route('siswa.destroy', $s->id_siswa) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        class="p-3 bg-red-50/50 hover:bg-red-100/50 rounded-xl text-red-600 hover:text-red-800 transition-colors duration-300 shadow-md transform hover:scale-110"
                                                        title="Hapus Siswa">
                                                        <i class="fas fa-trash-alt text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-8 py-6 bg-gradient-to-r from-gray-50/50 to-gray-100/50 dark:from-gray-800/50 dark:to-gray-700/50 border-t border-gray-200/50 dark:border-gray-600/50">
                            {{ $siswa->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- MODAL AREA - Letakkan di luar container utama -->
    <!-- Modal Tambah Siswa -->
    <div x-data="{ openAdd: false }" 
         @open-add-modal.window="openAdd = true">
        <div x-show="openAdd" x-cloak
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
             style="z-index: 99999 !important;"
             x-transition.opacity>
            <div @click.away="openAdd = false"
                 class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md p-6 relative"
                 style="z-index: 100000 !important;"
                 x-transition.scale.origin.center>
                <h3 class="text-xl font-black text-gray-800 dark:text-gray-100 mb-4 border-b pb-3">Tambah Siswa Baru</h3>
                <form action="{{ route('siswa.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Siswa</label>
                        <input type="text" name="nama_siswa" required
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIS</label>
                        <input type="number" name="nis" required
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="openAdd = false"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Batal</button>
                        <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 transition-colors shadow-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Global -->
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
    }" 
    @open-edit-modal.window="setEditData($event.detail.id, $event.detail.nama, $event.detail.nis)">
        <div x-show="openEdit" x-cloak
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
             style="z-index: 99999 !important;"
             x-transition.opacity>
            <div @click.away="openEdit = false"
                 class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-md p-6 relative"
                 style="z-index: 100000 !important;"
                 x-transition.scale.origin.center>
                <h2 class="text-xl font-black mb-4 text-gray-800 dark:text-white border-b pb-3">Edit Data Siswa</h2>
                <form :action="`{{ url('admin/siswa') }}/${editId}`" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
                        <input type="text" name="nama_siswa" x-model="editNama"
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NIS</label>
                        <input type="text" name="nis" x-model="editNis"
                            class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="openEdit = false"
                            class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Batal</button>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 transition-colors shadow-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }
        
        /* Alpine.js cloak */
        [x-cloak] { 
            display: none !important; 
        }
        
        .wave {
            animation: wave 2s infinite;
            transform-origin: 70% 70%;
            display: inline-block;
        }
        
        @keyframes wave {
            0% { transform: rotate(0deg); }
            10% { transform: rotate(14deg); }
            20% { transform: rotate(-8deg); }
            30% { transform: rotate(14deg); }
            40% { transform: rotate(-4deg); }
            50% { transform: rotate(10deg); }
            60% { transform: rotate(0deg); }
            100% { transform: rotate(0deg); }
        }
        
        @keyframes fade-in-up {
            from { 
                opacity: 0; 
                transform: translateY(50px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        @keyframes gradient-x {
            0%, 100% {
                background-size: 200% 200%;
                background-position: left center;
            }
            50% {
                background-size: 200% 200%;
                background-position: right center;
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .animate-gradient-x {
            animation: gradient-x 6s ease infinite;
        }
        
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }
        
        .group:hover .group-hover\:rotate-12 {
            transform: rotate(12deg);
        }
        
        .group:hover .group-hover\:-translate-y-1 {
            transform: translateY(-4px);
        }
        
        .group:hover .group-hover\:translate-x-full {
            transform: translate(100%);
        }

        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
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
            transition: all 0.3s ease;
        }
        
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #4f46e5, #7c3aed, #db2777);
        }
    </style>

    <script>
        function siswaModal() {
            return {
                // Global modal functions if needed
            }
        }

        // Trigger modal from button clicks
        document.addEventListener('DOMContentLoaded', function() {
            // Update button click handler
            const tambahBtn = document.querySelector('button[\\@click="openAdd = true"]');
            if (tambahBtn) {
                tambahBtn.addEventListener('click', function() {
                    window.dispatchEvent(new CustomEvent('open-add-modal'));
                });
            }

            // Update edit button handlers
            document.addEventListener('click', function(e) {
                if (e.target.closest('.fas.fa-edit')) {
                    e.preventDefault();
                    const button = e.target.closest('button');
                    const id = button.getAttribute('data-id') || button.closest('tr').querySelector('[data-id]')?.getAttribute('data-id');
                    const nama = button.getAttribute('data-nama') || button.closest('tr').querySelector('[data-nama]')?.getAttribute('data-nama');  
                    const nis = button.getAttribute('data-nis') || button.closest('tr').querySelector('[data-nis]')?.getAttribute('data-nis');
                    
                    window.dispatchEvent(new CustomEvent('open-edit-modal', {
                        detail: { id, nama, nis }
                    }));
                }
            });
        });
    </script>
</x-app-layout>