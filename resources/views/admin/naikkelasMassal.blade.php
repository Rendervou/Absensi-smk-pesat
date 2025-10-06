<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Naik Kelas Massal') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Kelola kenaikan kelas siswa secara massal
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-8 bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:from-gray-900 dark:via-gray-800 dark:to-teal-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <section x-data="naikKelasData()">
                
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

                <!-- Filter Kelas Asal -->
                <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-6 mb-6">
                    <h3 class="text-xl font-black text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-emerald-500"></i>
                        Pilih Kelas Asal
                    </h3>
                    <form method="GET" action="{{ route('admin.naikkelas.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kelas Asal</label>
                            <select name="kelas_asal" class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                <option value="{{ $k->id_kelas }}" {{ request('kelas_asal') == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 px-6 rounded-2xl font-bold hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 shadow-lg">
                                <i class="fas fa-search mr-2"></i>Tampilkan Siswa
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form Naik Kelas -->
                @if($siswaList->isNotEmpty())
                <form method="POST" action="{{ route('admin.naikkelas.proses') }}" x-ref="formNaikKelas">
                    @csrf
                    
                    <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-6 mb-6">
                        <h3 class="text-xl font-black text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
                            <i class="fas fa-graduation-cap text-teal-500"></i>
                            Pilih Kelas & Jurusan Tujuan
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Kelas Tujuan *</label>
                                <select name="kelas_tujuan" required class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                                    <option value="">-- Pilih Kelas Tujuan --</option>
                                    @foreach($kelas as $k)
                                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Jurusan Tujuan *</label>
                                <select name="jurusan_tujuan" required class="w-full rounded-2xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-3">
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach($jurusan as $j)
                                    <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Siswa -->
                    <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-emerald-500/10 via-teal-500/10 to-cyan-500/10 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-black text-gray-800 dark:text-gray-100">
                                        Daftar Siswa Kelas {{ $kelasAsal->nama_kelas ?? '' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Pilih siswa yang akan naik kelas (Total: {{ $siswaList->count() }} siswa)
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="pilihSemua()" class="px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl font-semibold hover:bg-emerald-200 transition-colors">
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
                                            <input type="checkbox" @click="toggleAll($event)" class="w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        </th>
                                        <th class="px-6 py-4">No.</th>
                                        <th class="px-6 py-4">Nama Siswa</th>
                                        <th class="px-6 py-4">NIS</th>
                                        <th class="px-6 py-4">Kelas Saat Ini</th>
                                        <th class="px-6 py-4">Jurusan</th>
                                        <th class="px-6 py-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($siswaList as $index => $siswa)
                                    <tr class="hover:bg-emerald-50/50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 text-center">
                                            <input type="checkbox" name="siswa_ids[]" value="{{ $siswa['id_siswa'] }}" class="siswa-checkbox w-5 h-5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        </td>
                                        <td class="px-6 py-4">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $siswa['nama_siswa'] }}</td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $siswa['nis'] }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ $siswa['kelas'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $siswa['jurusan'] }}</td>
                                        <td class="px-6 py-4">
                                            @if($siswa['status'] == 'aktif')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Aktif</span>
                                            @else
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">{{ ucfirst(str_replace('_', ' ', $siswa['status'])) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span x-text="selectedCount"></span> siswa dipilih
                                </div>
                                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-2xl font-bold hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 shadow-lg" onclick="return confirm('Yakin ingin memproses naik kelas untuk siswa yang dipilih?')">
                                    <i class="fas fa-arrow-up mr-2"></i>Proses Naik Kelas
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                <div class="bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-xl border border-white/50 dark:border-gray-700/50 p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Tidak Ada Data Siswa</h3>
                    <p class="text-gray-600 dark:text-gray-400">Silakan pilih kelas asal untuk menampilkan daftar siswa</p>
                </div>
                @endif

            </section>
        </div>
    </div>

    <script>
        function naikKelasData() {
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
                    // Listen untuk perubahan checkbox
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