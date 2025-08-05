<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <!-- Start coding here -->
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden p-5">
            <a href="/inputkehadiran"><button type="button" class="flex items-center gap-3 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-5">Absen Kehadiran<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </button></a>
            <div class="flex justify-center items-center mb-4 gap-5">
                <div class="block size-56 p-6 bg-gray-200 rounded-lg shadow-sm shadow shadow-2xl relative">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">Total Siswa</h5>
                    <div class="m-5 text-end absolute bottom-0 right-0">
                        <span class="font-bold text-7xl text-gray-900">308</span>
                    </div>
                </div>    
                <div class="block size-56 p-6 bg-blue-600 rounded-lg shadow-sm shadow shadow-2xl relative">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Hadir Hari Ini</h5>
                    <div class="m-5 text-end absolute bottom-0 right-0">
                        <span class="font-bold text-7xl text-white">240</span>
                    </div>
                </div>
                <div class="block size-56 p-6 bg-green-600 rounded-lg shadow-sm shadow shadow-2xl relative">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Izin</h5>
                    <div class="m-5 text-end absolute bottom-0 right-0">
                        <span class="font-bold text-7xl text-white">2</span>
                    </div>
                </div>
                <div class="block size-56 p-6 bg-red-600 rounded-lg shadow-sm shadow shadow-2xl relative">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Sakit</h5>
                    <div class="m-5 text-end absolute bottom-0 right-0">
                        <span class="font-bold text-7xl text-white">11</span>
                    </div>
                </div>
                <div class="block size-56 p-6 bg-black rounded-lg shadow-sm shadow shadow-2xl relative">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-red-600">Tanpa Keterangan</h5>
                    <div class="m-5 text-end absolute bottom-0 right-0">
                        <span class="font-bold text-7xl text-red-600">0</span>
                    </div>
                </div>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                NIS
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kehadiran
                            </th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Daffa Rafif Ramadhan
                            </th>
                            <td class="px-6 py-4">
                                0185354558
                            </td>
                            <td class="px-6 py-4">
                                Hadir
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Daffa Rafif Ramadhan
                            </th>
                            <td class="px-6 py-4">
                                0185354558
                            </td>
                            <td class="px-6 py-4">
                                Hadir
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Daffa Rafif Ramadhan
                            </th>
                            <td class="px-6 py-4">
                                0185354558
                            </td>
                            <td class="px-6 py-4">
                                Hadir
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Daffa Rafif Ramadhan
                            </th>
                            <td class="px-6 py-4">
                                0185354558
                            </td>
                            <td class="px-6 py-4">
                                juga
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </section>
</x-app-layout>
