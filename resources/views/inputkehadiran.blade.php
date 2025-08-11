<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Input Kehadiran
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        
        <form class="p-6">
            <select id="Kelas" class="w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-10">

            <option selected>Pilih Kelas</option>
            <option value="x-1">X 1</option>
            <option value="x-2">X 2</option>
            <option value="x-3">X 3</option>
            <option value="xi-1">XI 1</option>
            <option value="xi-2">XI 2</option>
            <option value="xi-3">XI 3</option>
            <option value="xii-rpl1">XII RPL 1</option>
            <option value="xii-rpl2">XII RPL 2</option>
            <option value="xii-dkv">XII DKV</option>
            <option value="xii-tkj">XII TKJ</option>
            </select>

            {{-- table --}}
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg  border border-gray-800 shadow-black shadow-md mb-5">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                    No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                    Nama Siswa
                    </th>
                    <th scope="col" class="pl-20 py-3">
                    Kehadiran
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    1
                    </th>
                    <td class="px-6 py-4">
                    Daffa Rafif Ramadhan
                    </td>
                    <td class="py-4">
                    <fieldset class="flex justify-around items-center gap-10">
                    <div class="flex items-center mb-4">
                        <input id="kehadiran-opsi-1" type="radio" name="kehadiran" value="hadir" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
                        <label for="kehadiran-opsi-1" class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
                        Hadir
                        </label>
                    </div>

                    <div class="flex items-center mb-4">
                        <input id="kehadiran-opsi-2" type="radio" name="kehadiran" value="sakit" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="kehadiran-opsi-2" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Sakit
                        </label>
                    </div>

                    <div class="flex items-center mb-4">
                        <input id="kehadiran-opsi-3" type="radio" name="kehadiran" value="izin" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="kehadiran-opsi-3" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Izin
                        </label>
                    </div>

                    <div class="flex items-center mb-4">
                        <input id="kehadiran-opsi-4" type="radio" name="kehadiran" value="alpha" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus-ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="kehadiran-opsi-4" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        Tanpa keterangan
                        </label>
                    </div>
                    </fieldset>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="flex justify-center">
            <button type="submit" class="text-white bg-gradient-to-r from-blue-300 via-blue-500 to-blue-800 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm w-32 py-2.5 text-center mx-auto mb-2 ">Submit</button>
            </div>
        </form>


            <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    </section>
</x-app-layout>