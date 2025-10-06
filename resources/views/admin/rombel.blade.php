<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 via-cyan-600 to-indigo-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Rombel') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Kelola data rombel dengan mudah
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
    
    <div class="py-8 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 min-h-screen relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-r from-blue-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-r from-pink-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-emerald-400/10 to-cyan-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <section x-data="{ 
                openRombel: false, 
                openBulkRombel: false,
                openEditRombel: false,
                editData: {
                    id: '',
                    id_siswa: '',
                    id_kelas: '',
                    id_jurusan: ''
                }
            }">
                <div class="flex flex-col sm:flex-row items-center justify-between mb-6 gap-4 animate-fade-in-up">
                    <form action="{{route('rombel.index')}}" method="get" class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                        <div class="relative w-full sm:w-auto">
                            <input id="searchInput" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" type="text" placeholder="Cari Nama Siswa...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <select id="kelas" name="kelas"
                            class="w-full sm:w-48 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelas as $k)
                            <option value="{{$k->id_kelas}}" {{ request('kelas') == $k->id_kelas ? 'selected' : '' }}>{{$k->nama_kelas}}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-orange-600 text-white font-medium rounded-full shadow-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105">
                            Cari
                        </button>
                    </form>

                    <div class="flex gap-3">
                        <!-- Tombol Tambah Massal (BARU) -->
                        <button @click="openBulkRombel = true"
                            class="group flex items-center gap-3 text-white bg-gradient-to-r from-purple-600 via-purple-700 to-pink-700 hover:from-purple-700 hover:via-purple-800 hover:to-pink-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-bold rounded-2xl text-sm px-6 py-3.5 text-center dark:focus:ring-purple-800 transition-all duration-500 transform group-hover:scale-105 shadow-2xl hover:shadow-purple-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                            Tambah Massal
                        </button>
                    </div>
                </div>

                <!-- Modal Tambah Satuan (EXISTING) -->
                <div x-show="openRombel" x-cloak
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[99] p-4" 
                    x-transition:enter="transition ease-out duration-300" 
                    x-transition:enter-start="opacity-0 scale-90" 
                    x-transition:enter-end="opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-300" 
                    x-transition:leave-start="opacity-100 scale-100" 
                    x-transition:leave-end="opacity-0 scale-90">
                    <div @click.away="openRombel = false"
                        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md p-6 animate-zoom-in">
                        <div class="flex justify-between items-center pb-3 mb-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Tambah Rombel Satuan</h3>
                            <button @click="openRombel = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{route('rombel.store')}}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Siswa</label>
                                <select name="id_siswa" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Nama Siswa --</option>
                                    @foreach ($siswa as $item)
                                    <option value="{{$item->id_siswa}}">{{$item->nama_siswa}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                                <select name="id_kelas" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                    <option value="{{$item->id_kelas}}">{{$item->nama_kelas}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jurusan</label>
                                <select name="id_jurusan" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($jurusan as $item)
                                    <option value="{{$item->id_jurusan}}">{{$item->nama_jurusan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" @click="openRombel = false"
                                    class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 transition-colors shadow-lg">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Tambah Massal (NEW) -->
                <div x-show="openBulkRombel" x-cloak
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[99] p-4" 
                    x-transition:enter="transition ease-out duration-300" 
                    x-transition:enter-start="opacity-0 scale-90" 
                    x-transition:enter-end="opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-300" 
                    x-transition:leave-start="opacity-100 scale-100" 
                    x-transition:leave-end="opacity-0 scale-90">
                    <div @click.away="openBulkRombel = false"
                        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-4xl p-6 animate-zoom-in max-h-[90vh] overflow-y-auto">
                        <div class="flex justify-between items-center pb-3 mb-4 border-b border-gray-200 dark:border-gray-700">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Tambah Rombel Massal</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pilih kelas & jurusan, lalu pilih siswa yang akan ditambahkan</p>
                            </div>
                            <button @click="openBulkRombel = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form action="{{route('rombel.bulkStore')}}" method="POST" class="space-y-4" x-data="{
                            selectedKelas: '',
                            selectedJurusan: '',
                            selectAll: false,
                            selectedCount: 0,
                            toggleAll() {
                                const checkboxes = document.querySelectorAll('.siswa-checkbox');
                                checkboxes.forEach(cb => cb.checked = this.selectAll);
                                this.updateCount();
                            },
                            updateCount() {
                                this.selectedCount = document.querySelectorAll('.siswa-checkbox:checked').length;
                            }
                        }">
                            @csrf
                            
                            <!-- Filter Kelas & Jurusan -->
                            <div class="grid grid-cols-2 gap-4 p-4 bg-blue-50 dark:bg-gray-700 rounded-2xl">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas <span class="text-red-500">*</span></label>
                                    <select name="id_kelas" x-model="selectedKelas" required
                                        class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelas as $item)
                                        <option value="{{$item->id_kelas}}">{{$item->nama_kelas}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jurusan <span class="text-gray-400">(Opsional)</span></label>
                                    <select name="id_jurusan" x-model="selectedJurusan"
                                        class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">-- Tanpa Jurusan --</option>
                                        @foreach ($jurusan as $item)
                                        <option value="{{$item->id_jurusan}}">{{$item->nama_jurusan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Daftar Siswa dengan Checkbox -->
                            <div x-show="selectedKelas" class="space-y-3" x-data="{ searchSiswa: '' }">
                                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-xl">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="font-bold text-gray-800 dark:text-gray-200">Pilih Semua Siswa</span>
                                    </label>
                                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400" x-text="selectedCount + ' siswa dipilih'"></span>
                                </div>

                                <!-- Search Box di Modal -->
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        x-model="searchSiswa"
                                        placeholder="Cari nama siswa atau NIS..." 
                                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300"
                                    >
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <button 
                                        x-show="searchSiswa" 
                                        @click="searchSiswa = ''"
                                        type="button"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="max-h-96 overflow-y-auto space-y-2 p-2">
                                    @forelse ($siswa as $item)
                                    <label 
                                        x-show="searchSiswa === '' || '{{strtolower($item->nama_siswa)}} {{strtolower($item->nis)}}'.includes(searchSiswa.toLowerCase())"
                                        class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer border border-gray-200 dark:border-gray-600">
                                        <input type="checkbox" name="siswa_ids[]" value="{{$item->id_siswa}}" 
                                            class="siswa-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                            @change="updateCount()">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($item->nama_siswa, 0, 2) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 dark:text-gray-200">{{$item->nama_siswa}}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">NIS: {{$item->nis}}</p>
                                            </div>
                                        </div>
                                    </label>
                                    @empty
                                    <div class="text-center py-8">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="mt-2 text-gray-500 dark:text-gray-400 font-medium">Tidak ada siswa yang tersedia</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500">Semua siswa sudah masuk rombel</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" @click="openBulkRombel = false"
                                    class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Batal
                                </button>
                                <button type="submit" :disabled="selectedCount === 0"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 transition-colors shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="{ 'opacity-50 cursor-not-allowed': selectedCount === 0 }">
                                    <span x-text="'Simpan (' + selectedCount + ' siswa)'"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Edit Rombel (NEW) -->
                <div x-show="openEditRombel" x-cloak
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[99] p-4" 
                    x-transition:enter="transition ease-out duration-300" 
                    x-transition:enter-start="opacity-0 scale-90" 
                    x-transition:enter-end="opacity-100 scale-100" 
                    x-transition:leave="transition ease-in duration-300" 
                    x-transition:leave-start="opacity-100 scale-100" 
                    x-transition:leave-end="opacity-0 scale-90">
                    <div @click.away="openEditRombel = false"
                        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md p-6 animate-zoom-in">
                        <div class="flex justify-between items-center pb-3 mb-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Edit Rombel</h3>
                            <button @click="openEditRombel = false"
                                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <form :action="'{{ route('rombel.index') }}/' + editData.id" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Siswa</label>
                                <select name="id_siswa" x-model="editData.id_siswa" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Nama Siswa --</option>
                                    @if(isset($allSiswa))
                                        @foreach ($allSiswa as $item)
                                        <option value="{{$item->id_siswa}}">{{$item->nama_siswa}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                                <select name="id_kelas" x-model="editData.id_kelas" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $item)
                                    <option value="{{$item->id_kelas}}">{{$item->nama_kelas}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jurusan</label>
                                <select name="id_jurusan" x-model="editData.id_jurusan" required
                                    class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach ($jurusan as $item)
                                    <option value="{{$item->id_jurusan}}">{{$item->nama_jurusan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button type="button" @click="openEditRombel = false"
                                    class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-2xl text-gray-600 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-blue-600 text-white rounded-2xl font-semibold hover:bg-blue-700 transition-colors shadow-lg">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Data Rombel -->
                <div class="animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 overflow-hidden relative">
                        <div class="px-8 py-6 bg-gradient-to-r from-indigo-500/10 via-purple-500/10 to-pink-500/10 dark:from-indigo-900/20 dark:via-purple-900/20 dark:to-pink-900/20 border-b border-indigo-200/30 dark:border-gray-600/50">
                            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                        <i class="fas fa-school text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-black text-gray-800 dark:text-gray-100">Data Rombel</h3>
                                        <p class="text-gray-600 dark:text-gray-300">Kelola rombongan belajar secara terperinci</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table id="Table" class="w-full text-sm text-left">
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
                                        <th scope="col" class="px-6 py-6 font-bold">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-school text-lg text-blue-500"></i>
                                                Kelas
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-6 font-bold">
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-microchip text-lg text-emerald-500"></i>
                                                Jurusan
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
                                    @foreach ($rombels as $item)
                                    <tr class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300 group">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center">
                                                <span class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full flex items-center justify-center text-sm font-black shadow-md">{{ $rombels->firstItem() + $loop->index }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                                    {{ substr($item->nama_siswa, 0, 2) }}
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-black text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">{{ $item->nama_siswa }}</h3>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{$item->nama_kelas}}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                {{$item->nama_jurusan}}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <button
                                                    @click="editData = { id: '{{$item->id}}', id_siswa: '{{$item->id_siswa}}', id_kelas: '{{$item->id_kelas}}', id_jurusan: '{{$item->id_jurusan}}' }; openEditRombel = true"
                                                    type="button"
                                                    class="p-3 bg-blue-50/50 hover:bg-blue-100/50 rounded-xl text-blue-600 hover:text-blue-800 transition-colors duration-300 shadow-md transform hover:scale-110"
                                                    title="Edit Rombel">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </button>
                                                <form action="{{ route('rombel.destroy', $item->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus rombel ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-3 bg-red-50/50 hover:bg-red-100/50 rounded-xl text-red-600 hover:text-red-800 transition-colors duration-300 shadow-md transform hover:scale-110"
                                                        title="Hapus Rombel">
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
                            {{ $rombels->links() }}
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

        @keyframes zoom-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
            opacity: 0;
        }
        
        .animate-zoom-in {
            animation: zoom-in 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
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
        // Tidak perlu lagi auto-submit karena sudah ada tombol Cari
    </script>
</x-app-layout>