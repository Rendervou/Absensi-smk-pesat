<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-3">
                <span class="text-4xl">📊</span>
                Data Kelas
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 mb-8 text-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Data Kelas</h3>
                        <p class="text-blue-100">Kelola data kelas dengan mudah</p>
                    </div>
                    <button onclick="openModal('add')" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Kelas
                    </button>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Kelas
                        </label>
                        <input type="text" 
                               id="search" 
                               placeholder="Cth: X-1" 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200">
                    </div>
                    <div class="flex items-end gap-2">
                        <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                        <button class="px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-medium transition-all duration-200">
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Table Header -->
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7l-5 5-5-5"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Data Kelas</h3>
                            <p class="text-purple-100">Daftar semua kelas yang terdaftar</p>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                            #
                                        </span>
                                        No.
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        <span class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400">
                                            📚
                                        </span>
                                        Kelas
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                                            ⚙️
                                        </span>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $sampleKelas = [
                                    ['id' => 1, 'nama' => 'X-1'],
                                    ['id' => 2, 'nama' => 'X-2'],
                                    ['id' => 3, 'nama' => 'X-3'],
                                    ['id' => 4, 'nama' => 'XI-1'],
                                    ['id' => 5, 'nama' => 'XI-2'],
                                    ['id' => 6, 'nama' => 'XI-3'],
                                ];
                            @endphp
                            
                            @foreach($sampleKelas as $index => $kelas)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold">
                                            {{ substr($kelas['nama'], 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $kelas['nama'] }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Kelas {{ $kelas['nama'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openModal('edit', {{ $kelas['id'] }}, '{{ $kelas['nama'] }}')" 
                                                class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-all duration-200 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </button>
                                        <button onclick="deleteKelas({{ $kelas['id'] }}, '{{ $kelas['nama'] }}')" 
                                                class="inline-flex items-center gap-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-all duration-200 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1-1 0-00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">6</span> dari <span class="font-medium">6</span> hasil
                        </div>
                        <div class="flex gap-1">
                            <button class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 dark:text-gray-400">
                                Sebelumnya
                            </button>
                            <button class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg font-medium">
                                1
                            </button>
                            <button class="px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-500 dark:text-gray-400">
                                Selanjutnya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<!-- Modal DIPINDAH KE LUAR layout supaya tidak ketimpa -->
<div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden transition-opacity duration-300 z-[999999]">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div id="modal-container" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 z-[1000000]">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-2xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 id="modal-title" class="text-xl font-bold text-white">Tambah Kelas</h3>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <form id="kelas-form" class="p-6">
                <input type="hidden" id="kelas-id" name="id">
                <div class="mb-6">
                    <label for="nama-kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama-kelas" name="nama_kelas" placeholder="Contoh: X-1, XI-IPA-1, XII-IPS-2"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-all duration-200" required>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Masukkan nama kelas yang unik dan mudah diidentifikasi
                    </p>
                </div>
                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-xl font-medium transition-all duration-200">
                        Batal
                    </button>
                    <button type="submit" id="submit-btn" class="flex-1 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span id="submit-text">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
        let currentMode = 'add';
        let currentId = null;

        // Fungsi untuk membuka modal
        function openModal(mode, id = null, nama = '') {
            currentMode = mode;
            currentId = id;
            
            const modal = document.getElementById('modal-overlay');
            const container = document.getElementById('modal-container');
            const title = document.getElementById('modal-title');
            const namaInput = document.getElementById('nama-kelas');
            const idInput = document.getElementById('kelas-id');
            const submitText = document.getElementById('submit-text');
            
            // Pastikan modal berada di atas semua elemen
            modal.style.zIndex = '999999';
            modal.style.position = 'fixed';
            container.style.zIndex = '1000000';
            container.style.position = 'relative';
            
            // Disable body scroll
            document.body.style.overflow = 'hidden';
            
            // Set modal content based on mode
            if (mode === 'add') {
                title.textContent = 'Tambah Kelas Baru';
                submitText.textContent = 'Tambah Kelas';
                namaInput.value = '';
                idInput.value = '';
            } else {
                title.textContent = 'Edit Kelas';
                submitText.textContent = 'Update Kelas';
                namaInput.value = nama;
                idInput.value = id;
            }
            
            // Show modal with animation
            modal.classList.remove('hidden');
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
                container.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Focus input
            setTimeout(() => namaInput.focus(), 100);
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            const modal = document.getElementById('modal-overlay');
            const container = document.getElementById('modal-container');
            
            // Enable body scroll
            document.body.style.overflow = 'auto';
            
            container.classList.remove('scale-100', 'opacity-100');
            container.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Fungsi untuk delete kelas
        function deleteKelas(id, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus kelas "${nama}"?`)) {
                // Di sini Anda bisa menambahkan logic untuk menghapus data
                alert(`Kelas "${nama}" berhasil dihapus!`);
                // Reload atau update table
                location.reload();
            }
        }

        // Handle form submission
        document.getElementById('kelas-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const namaKelas = document.getElementById('nama-kelas').value.trim();
            
            if (!namaKelas) {
                alert('Nama kelas tidak boleh kosong!');
                return;
            }
            
            // Disable submit button
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const originalText = submitText.textContent;
            
            submitBtn.disabled = true;
            submitText.textContent = 'Menyimpan...';
            
            // Simulate API call
            setTimeout(() => {
                if (currentMode === 'add') {
                    alert(`Kelas "${namaKelas}" berhasil ditambahkan!`);
                } else {
                    alert(`Kelas "${namaKelas}" berhasil diupdate!`);
                }
                
                // Reset button
                submitBtn.disabled = false;
                submitText.textContent = originalText;
                
                closeModal();
                // Reload page or update table
                location.reload();
            }, 1000);
        });

        // Close modal when clicking outside
        document.getElementById('modal-overlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>