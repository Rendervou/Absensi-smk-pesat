<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absensi') }}
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-screen">
        <!-- Filter Form - Responsive -->
        <form action="{{route('user.presensi.index')}}" method="get" class="flex flex-col sm:flex-row mb-6 sm:mb-10 items-stretch sm:items-center gap-3 sm:gap-5">
            <select id="kelas" name="kelas"
                class="w-full sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-orange-500 w-full sm:w-36 py-2.5 sm:py-2 rounded-lg text-white font-medium hover:bg-orange-600 transition-colors">
                Cari
            </button>
        </form>

        <form class="">
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-white dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <span class="w-8 h-8 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center text-sm font-bold">#</span>
                                    No.
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Nama Siswa
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Kehadiran
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($rombels as $s)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="w-8 h-8 bg-blue-500 dark:bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">{{$loop->iteration}}</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase">{{$s->nama_siswa}}</h3>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                        </svg>
                                        {{$s->nama_kelas}}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <fieldset class="flex justify-around items-center gap-6">
                                    <div class="flex items-center">
                                        <input id="hadir_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="hadir"
                                            class="w-4 h-4 text-green-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-500 dark:focus:ring-green-600 dark:bg-gray-700" checked>
                                        <label for="hadir_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hadir</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="sakit_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="sakit"
                                            class="w-4 h-4 text-yellow-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:bg-gray-700">
                                        <label for="sakit_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sakit</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="izin_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="izin"
                                            class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 dark:bg-gray-700">
                                        <label for="izin_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Izin</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="alfa_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="alfa"
                                            class="w-4 h-4 text-red-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-red-500 dark:focus:ring-red-600 dark:bg-gray-700">
                                        <label for="alfa_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alfa</label>
                                    </div>
                                </fieldset>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-4">
                @foreach ($rombels as $s)
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-4">
                    <!-- Student Info -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-10 h-10 bg-blue-500 dark:bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                            {{$loop->iteration}}
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 uppercase truncate">{{$s->nama_siswa}}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                </svg>
                                <span class="truncate">{{$s->nama_kelas}}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Options -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Pilih Kehadiran:</p>
                        <fieldset class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                            <div class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input id="hadir_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="hadir"
                                    class="w-4 h-4 text-green-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-green-500 dark:bg-gray-700" checked>
                                <label for="hadir_mobile_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hadir</label>
                            </div>

                            <div class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input id="sakit_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="sakit"
                                    class="w-4 h-4 text-yellow-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 dark:bg-gray-700">
                                <label for="sakit_mobile_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Sakit</label>
                            </div>

                            <div class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input id="izin_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="izin"
                                    class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                                <label for="izin_mobile_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Izin</label>
                            </div>

                            <div class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input id="alfa_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="alfa"
                                    class="w-4 h-4 text-red-600 border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-red-500 dark:bg-gray-700">
                                <label for="alfa_mobile_{{ $s->id_siswa }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Alfa</label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="w-full sm:w-auto min-w-[200px] rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors text-sm px-6 py-3">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </section>
</x-app-layout>