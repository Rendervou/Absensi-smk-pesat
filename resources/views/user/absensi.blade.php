<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-5">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-pink-500 rounded-2xl flex items-center justify-center shadow-xl transform transition-transform duration-300 hover:scale-110">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 4h2m0 0H6m10 5h2m0 0H6m-2 4h4m-4 0v-4m-2 2h-4m2 2h2"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3h8v4M4 17h16M4 21h16a2 2 0 002-2v-8a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-3xl text-gray-900 dark:text-gray-100 leading-tight tracking-wide">{{ __('Absensi Kehadiran Siswa') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-2">
                        <i class="far fa-calendar-alt text-indigo-500"></i> {{ date('l, d F Y') }} • Silakan Absen
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 bg-gradient-to-r from-indigo-600 to-pink-500 rounded-full px-4 py-2 shadow-lg">
                <div class="text-right text-white">
                    <p class="text-sm font-semibold">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs opacity-80">Administrator</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center shadow-md">
                    <span class="text-white font-bold text-lg select-none">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <section class="bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 p-6 sm:p-10 min-h-screen">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg mb-8 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('user.presensi.index') }}" method="get" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-5">
                <div class="flex-grow">
                    <select id="kelas" name="kelas"
                        class="w-full bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-200 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 transition-shadow duration-300 shadow-sm hover:shadow-md">
                        <option value="">{{ $kelasNama ?? 'Semua Kelas' }}</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 w-full sm:w-auto px-7 py-3 rounded-xl text-white font-semibold hover:bg-indigo-700 transition-colors duration-300 flex items-center justify-center gap-3 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Kelas / Reset
                </button>
            </form>
        </div>

        <h2 class="font-extrabold text-2xl mb-6 dark:text-gray-100 text-gray-900 tracking-wide">
            Daftar Absensi Kelas <span class="text-indigo-600 dark:text-indigo-400">{{ $kelasNama ?? 'Semua Kelas' }}</span>
        </h2>

        <form id="formAbsensi" action="{{ route('user.presensi.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="hidden lg:block overflow-x-auto rounded-3xl border border-gray-200 dark:border-gray-700 shadow-xl">
                <table class="w-full table-auto border-collapse">
                    <thead class="bg-indigo-100 dark:bg-indigo-900">
                        <tr>
                            <th class="px-8 py-5 text-left text-sm font-extrabold text-indigo-900 dark:text-indigo-300 uppercase tracking-wider border-b border-indigo-300 dark:border-indigo-700 rounded-tl-3xl">No.</th>
                            <th class="px-8 py-5 text-left text-sm font-extrabold text-indigo-900 dark:text-indigo-300 uppercase tracking-wider border-b border-indigo-300 dark:border-indigo-700">Nama Siswa</th>
                            <th class="px-8 py-5 text-left text-sm font-extrabold text-indigo-900 dark:text-indigo-300 uppercase tracking-wider border-b border-indigo-300 dark:border-indigo-700 rounded-tr-3xl">Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-indigo-200 dark:divide-indigo-700">
                        @foreach ($rombels as $s)
                        <tr class="transition-colors hover:bg-indigo-50 dark:hover:bg-indigo-800 cursor-pointer">
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-indigo-600 dark:text-indigo-400 font-semibold">{{ $loop->iteration }}</td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div>
                                    <h3 class="text-base font-semibold text-indigo-900 dark:text-indigo-100 uppercase tracking-wide">{{ $s->nama_siswa }}</h3>
                                    <div class="text-sm text-indigo-600 dark:text-indigo-400 mt-1">{{ $s->nama_kelas }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <input type="hidden" name="id_siswa[]" value="{{ $s->id_siswa }}">
                                <input type="hidden" name="id_kelas[]" value="{{ $s->id_kelas }}">
                                <fieldset class="flex items-center gap-6 sm:gap-8">
                                    <div class="flex items-center">
                                        <input id="hadir_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="hadir" checked class="h-5 w-5 text-indigo-600 bg-indigo-100 border-indigo-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-indigo-700 cursor-pointer transition duration-200">
                                        <label for="hadir_{{ $s->id_siswa }}" class="ml-2 text-sm font-semibold text-indigo-900 dark:text-indigo-200 cursor-pointer select-none">Hadir</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="sakit_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="sakit" class="h-5 w-5 text-yellow-500 bg-yellow-100 border-yellow-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-yellow-700 cursor-pointer transition duration-200">
                                        <label for="sakit_{{ $s->id_siswa }}" class="ml-2 text-sm font-semibold text-indigo-900 dark:text-indigo-200 cursor-pointer select-none">Sakit</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="izin_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="izin" class="h-5 w-5 text-green-600 bg-green-100 border-green-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-green-700 cursor-pointer transition duration-200">
                                        <label for="izin_{{ $s->id_siswa }}" class="ml-2 text-sm font-semibold text-indigo-900 dark:text-indigo-200 cursor-pointer select-none">Izin</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="alfa_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="alfa" class="h-5 w-5 text-red-600 bg-red-100 border-red-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-red-700 cursor-pointer transition duration-200">
                                        <label for="alfa_{{ $s->id_siswa }}" class="ml-2 text-sm font-semibold text-indigo-900 dark:text-indigo-200 cursor-pointer select-none">Alfa</label>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="lg:hidden space-y-6">
                @foreach ($rombels as $s)
                <div class="bg-white dark:bg-gray-800 rounded-3xl border border-indigo-200 dark:border-indigo-700 p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center gap-4 mb-5 border-b border-indigo-200 dark:border-indigo-700 pb-5">
                        <span class="w-12 h-12 bg-indigo-600 dark:bg-indigo-700 text-white rounded-full flex items-center justify-center text-lg font-extrabold shadow-md select-none">{{ $loop->iteration }}</span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg font-extrabold text-indigo-900 dark:text-indigo-100 uppercase tracking-wide">{{ $s->nama_siswa }}</h3>
                            <div class="text-sm text-indigo-600 dark:text-indigo-400">{{ $s->nama_kelas }}</div>
                        </div>
                    </div>

                    <input type="hidden" name="id_siswa[]" value="{{ $s->id_siswa }}">
                    <input type="hidden" name="id_kelas[]" value="{{ $s->id_kelas }}">

                    <fieldset class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                        <div class="flex items-center gap-3">
                            <input id="hadir_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="hadir" checked class="h-5 w-5 text-indigo-600 bg-indigo-100 border-indigo-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-indigo-700 cursor-pointer transition duration-200">
                            <label for="hadir_mobile_{{ $s->id_siswa }}" class="text-sm font-semibold text-indigo-900 dark:text-indigo-100 cursor-pointer select-none">Hadir</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input id="sakit_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="sakit" class="h-5 w-5 text-yellow-500 bg-yellow-100 border-yellow-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-yellow-700 cursor-pointer transition duration-200">
                            <label for="sakit_mobile_{{ $s->id_siswa }}" class="text-sm font-semibold text-indigo-900 dark:text-indigo-100 cursor-pointer select-none">Sakit</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input id="izin_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="izin" class="h-5 w-5 text-green-600 bg-green-100 border-green-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-green-700 cursor-pointer transition duration-200">
                            <label for="izin_mobile_{{ $s->id_siswa }}" class="text-sm font-semibold text-indigo-900 dark:text-indigo-100 cursor-pointer select-none">Izin</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input id="alfa_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="alfa" class="h-5 w-5 text-red-600 bg-red-100 border-red-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-900 focus:ring-2 dark:bg-gray-800 dark:border-red-700 cursor-pointer transition duration-200">
                            <label for="alfa_mobile_{{ $s->id_siswa }}" class="text-sm font-semibold text-indigo-900 dark:text-indigo-100 cursor-pointer select-none">Alfa</label>
                        </div>
                    </fieldset>
                </div>
                @endforeach
            </div>

            <div class="flex justify-end mt-10">
                <button type="button" id="btnSimpanAbsensi" class="w-full sm:w-auto min-w-[220px] rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-base px-10 py-4 shadow-lg transition-colors duration-300 hover:shadow-xl">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </section>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Konfirmasi sebelum submit
        document.getElementById('btnSimpanAbsensi').addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Penyimpanan',
                text: "Apakah Anda yakin ingin menyimpan data absensi ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold',
                    cancelButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    document.getElementById('formAbsensi').submit();
                }
            });
        });

        // Alert notifikasi dari session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#4F46E5',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-3 font-semibold'
                }
            });
        @endif
    </script>
</x-app-layout>