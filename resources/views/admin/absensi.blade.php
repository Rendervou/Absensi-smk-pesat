<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Absensi') }}
        </h2>
    </x-slot>


    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">

        <form action="{{route('presensi.index')}}" method="get" class="flex mb-10 items-center gap-5">
            <select id="kelas" name="kelas"
                class="w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                <option value="">Semua Kelas</option>
                @foreach ($kelas as $k)
                <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-orange-500 w-36 py-2 rounded-lg text-white">Cari</button>
        </form>
        <form class="">

            <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold">#</span>
                                    No.
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                    Nama Siswa
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider border-b">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Kehadiran
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    @foreach ($rombels as $s)
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">{{$loop->iteration}}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-900 uppercase">{{$s->nama_siswa}}</h3>
                                    <div class="text-sm text-gray-500 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                                        </svg>
                                        {{$s->nama_kelas}}
                                    </div>
                                </div>
                            </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <fieldset class="flex justify-around items-center gap-10">
                                    <div class="flex items-center mb-4">
                                        <input id="kehadiran-opsi-1" type="radio" name="kehadiran_{{ $s->id_siswa }}"
                                            value="hadir"
                                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600"
                                            checked>
                                        <label for="kehadiran-opsi-1"
                                            class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Hadir
                                        </label>
                                    </div>

                                    <div class="flex items-center mb-4">
                                        <input id="kehadiran-opsi-2" type="radio" name="kehadiran_{{ $s->id_siswa }}"
                                            value="sakit"
                                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="kehadiran-opsi-2"
                                            class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Sakit
                                        </label>
                                    </div>

                                    <div class="flex items-center mb-4">
                                        <input id="kehadiran-opsi-3" type="radio" name="kehadiran_{{ $s->id_siswa }}"
                                            value="izin"
                                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="kehadiran-opsi-3"
                                            class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Izin
                                        </label>
                                    </div>

                                    <div class="flex items-center mb-4">
                                        <input id="kehadiran-opsi-4" type="radio" name="kehadiran_{{ $s->id_siswa }}"
                                            value="alpha"
                                            class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus-ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="kehadiran-opsi-4"
                                            class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Alpa
                                        </label>
                                    </div>
                                </fieldset>

                            </td>
                        </tr>

                    </tbody>
                    @endforeach
                </table>
            </div>

            <div class=" flex justify-end mt-4">
                <button type="submit"
                    class=" rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition text-sm w-52 py-3 mb-2 ">Simpan</button>
            </div>
        </form>



    </section>


</x-app-layout>