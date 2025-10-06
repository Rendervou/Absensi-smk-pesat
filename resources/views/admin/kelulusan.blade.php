<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-600 via-pink-600 to-red-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Kelulusan Siswa') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Kelola kelulusan siswa kelas XII
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-8 bg-gradient-to-br from-purple-50 via-white to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-purple-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <section x-data="kelulusanData()">
                
                <!-- Alert Messages -->
                <div class="mb-6">
                    @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 rounded-2xl shadow-lg mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-emerald-400 text-xl mr-3"></i>
                            <p class="text-emerald-800 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-2xl shadow-lg mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-400 text-xl mr-3"></i>
                            <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-2xl shadow-lg mb-4">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle text-red-400 text-xl mr-3"></i>
                            <div>
                                <h3 class="text-red-800 font-semibold mb-2">Terdapat kesalahan:</h3>
                                <ul class="list-disc list-inside text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Statistik Alumni -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-3xl shadow-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-semibold mb-1">Total Alumni</p>
                                <h3 class="text-4xl font-black">{{ $totalAlumni }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-user-graduate text-3xl"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-3xl shadow-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-semibold mb-1">Lulus Tahun Ini</p>
                                <h3 class="text-4xl font-black">{{ $alumniTahunIni }}</h3>
                            </div>
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-trophy text-3xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Kelas XII -->
                <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-6 mb-6">
                    <h3 class="text-xl font-black text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-purple-500"></i>
                        Pilih Kelas XII
                    </h3>
                    <form method="GET" action="{{ route('admin.kelulusan.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kelas XII</label>
                            <select name="kelas" class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                                <option value="">-- Pilih Kelas XII --</option>
                                @foreach($kelasXII as $k)
                                <option value="{{ $k->id_kelas }}" {{ request('kelas') == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-2xl font-bold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg">
                                <i class="fas fa-search mr-2"></i>Tampilkan Siswa
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form Kelulusan -->
                @if($siswaList->isNotEmpty())
                <form method="POST" action="{{ route('admin.kelulusan.proses') }}" x-ref="formKelulusan">
                    @csrf
                    
                    <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-6 mb-6">
                        <h3 class="text-xl font-black text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <i class="fas fa-calendar-check text-pink-500"></i>
                            Informasi Kelulusan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Tanggal Kelulusan *</label>
                                <input type="date" name="tanggal_kelulusan" required value="{{ date('Y-m-d') }}" class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Catatan (Opsional)</label>
                                <input type="text" name="catatan" placeholder="Misal: Lulus dengan predikat baik" class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Siswa -->
                    <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-purple-500/10 via-pink-500/10 to-red-500/10 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 dark:text-gray-100">
                                        Calon Lulusan - {{ $kelasSelected->nama_kelas ?? '' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Pilih siswa yang lulus (Total: {{ $siswaList->count() }} siswa)
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="pilihSemua()" class="px-4 py-2 bg-purple-100 text-purple-700 rounded-xl font-semibold hover:bg-purple-200 transition-colors">
                                        <i class="fas fa-check-double mr-1"></i> Pilih Semua
                                    </button>
                                    <button type="button" @click="batalPilih()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-times mr-1"></i> Batal Pilih
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 text-center">
                                            <input type="checkbox" @click="toggleAll($event)" class="w-5 h-5 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                        </th>
                                        <th class="px-6 py-4">No.</th>
                                        <th class="px-6 py-4">Nama Siswa</th>
                                        <th class="px-6 py-4">NIS</th>
                                        <th class="px-6 py-4">Kelas</th>
                                        <th class="px-6 py-4">Jurusan</th>
                                        <th class="px-6 py-4">No. Telp</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($siswaList as $index => $siswa)
                                    <tr class="hover:bg-purple-50/50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 text-center">
                                            <input type="checkbox" name="siswa_ids[]" value="{{ $siswa['id_siswa'] }}" class="siswa-checkbox w-5 h-5 rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                        </td>
                                        <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $siswa['nama_siswa'] }}</td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $siswa['nis'] }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">{{ $siswa['kelas'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $siswa['jurusan'] }}</td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $siswa['no_tlp'] ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span x-text="selectedCount"></span> siswa dipilih untuk lulus
                                </div>
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-2xl font-bold hover:from-purple-700 hover:to-pink-700 transition-all duration-300 shadow-lg" onclick="return confirm('Yakin ingin meluluskan siswa yang dipilih? Data akan dipindahkan ke tabel alumni.')">
                                    <i class="fas fa-graduation-cap mr-2"></i>Proses Kelulusan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Tidak Ada Calon Lulusan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Silakan pilih kelas XII untuk menampilkan daftar calon lulusan</p>
                </div>
                @endif

                <!-- Link ke Daftar Alumni -->
                <div class="mt-6 text-center">
                    <a href="{{ route('admin.alumni.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-2xl font-semibold hover:shadow-lg transition-all duration-300 border-2 border-gray-300 dark:border-gray-600">
                        <i class="fas fa-list"></i>
                        Lihat Daftar Alumni
                    </a>
                </div>

            </section>
        </div>
    </div>

    <script>
        function kelulusanData() {
            return {
                selectedCount: 0,
                
                updateCount() {
                    this.selectedCount = document.querySelectorAll('.siswa-checkbox:checked').length;
                },
                
                toggleAll(event) {
                    const checkboxes = document.querySelectorAll('.siswa-checkbox');
                    checkboxes.forEach(cb => cb.checked = event.target.checked);
                    this.updateCount();
                },
                
                pilihSemua() {
                    const checkboxes = document.querySelectorAll('.siswa-checkbox');
                    checkboxes.forEach(cb => cb.checked = true);
                    this.updateCount();
                },
                
                batalPilih() {
                    const checkboxes = document.querySelectorAll('.siswa-checkbox');
                    checkboxes.forEach(cb => cb.checked = false);
                    this.updateCount();
                },
                
                init() {
                    this.$nextTick(() => {
                        document.querySelectorAll('.siswa-checkbox').forEach(cb => {
                            cb.addEventListener('change', () => this.updateCount());
                        });
                    });
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
        }
    </style>
</x-app-layout>