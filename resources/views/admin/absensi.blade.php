<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absensi') }}
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 min-h-screen">
        <!-- Filter Form - Responsive -->
        <form action="{{route('admin.presensi.index')}}" method="get" class="flex flex-col sm:flex-row mb-6 sm:mb-10 items-stretch sm:items-center gap-3 sm:gap-5">
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

        <!-- FORM ABSENSI -->
        <form action="{{ route('admin.presensi.store') }}" method="POST">
            @csrf

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
                                Nama Siswa
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider border-b dark:border-gray-700">
                                Kehadiran
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
                                        {{$s->nama_kelas}}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- hidden input -->
                                <input type="hidden" name="id_siswa[]" value="{{ $s->id_siswa }}">
                                <input type="hidden" name="id_kelas[]" value="{{ $s->id_kelas }}">

                                <fieldset class="flex justify-around items-center gap-6">
                                    <div class="flex items-center">
                                        <input id="hadir_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="hadir" checked>
                                        <label for="hadir_{{ $s->id_siswa }}" class="ml-2">Hadir</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="sakit_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="sakit">
                                        <label for="sakit_{{ $s->id_siswa }}" class="ml-2">Sakit</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="izin_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="izin">
                                        <label for="izin_{{ $s->id_siswa }}" class="ml-2">Izin</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input id="alfa_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="alfa">
                                        <label for="alfa_{{ $s->id_siswa }}" class="ml-2">Alfa</label>
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
                <div class="bg-white dark:bg-gray-800 rounded-xl border p-4">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            {{$loop->iteration}}
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 uppercase">{{$s->nama_siswa}}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{$s->nama_kelas}}</div>
                        </div>
                    </div>

                    <input type="hidden" name="id_siswa[]" value="{{ $s->id_siswa }}">
                    <input type="hidden" name="id_kelas[]" value="{{ $s->id_kelas }}">

                    <fieldset class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <div>
                            <input id="hadir_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="hadir" checked>
                            <label for="hadir_mobile_{{ $s->id_siswa }}">Hadir</label>
                        </div>
                        <div>
                            <input id="sakit_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="sakit">
                            <label for="sakit_mobile_{{ $s->id_siswa }}">Sakit</label>
                        </div>
                        <div>
                            <input id="izin_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="izin">
                            <label for="izin_mobile_{{ $s->id_siswa }}">Izin</label>
                        </div>
                        <div>
                            <input id="alfa_mobile_{{ $s->id_siswa }}" type="radio" name="kehadiran_{{ $s->id_siswa }}" value="alfa">
                            <label for="alfa_mobile_{{ $s->id_siswa }}">Alfa</label>
                        </div>
                    </fieldset>
                </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="w-full sm:w-auto min-w-[200px] rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-6 py-3">
                    Simpan Absensi
                </button>
            </div>
        </form>
    </section>
</x-app-layout>
