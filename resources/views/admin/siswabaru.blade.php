<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Siswa Baru') }}
        </h2>
    </x-slot>

    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12 mt-6">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Masukan Data Siswa</h2>
        <form action="#">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label for="nama_siswa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Siswa</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Nama" required="">
                </div>
                <div class="w-full">
                    <label for="nis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Induk Siswa</label>
                    <input type="number" name="nis" id="nis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan NIS" required="">
                </div>
                <div class="w-full">
                    <label for="no_tlp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Telepon Siswa</label>
                    <input type="number" name="no_tlp" id="no_tlp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Nomor Telepon mulai dari 0" required="">
                </div>
                <div class="sm:col-span-2">
                    <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat Siswa</label>
                    <textarea id="alamat" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Masukan Alamat Siswa"></textarea>
                </div>
            </div>
            <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                Tambahkan Siswa Baru
            </button>
        </form>
    </div>
    </section>
</x-app-layout>