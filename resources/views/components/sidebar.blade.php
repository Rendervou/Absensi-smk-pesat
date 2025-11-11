<aside class="fixed top-0 left-0 w-16 lg:w-72 z-40 
    bg-white dark:bg-slate-900 
    min-h-screen border-r-2 border-gray-200 dark:border-gray-700 
    transition-all duration-300">

    <div class="w-full px-2 lg:px-5 py-10 flex flex-col dark:text-gray-200 items-center lg:items-start">
        <img src="{{ asset('assets/smkpesat.webp')}}" alt="" class="w-10 lg:w-24 mb-6">

        <ul class="space-y-2 w-full">
            <li>
                <x-nav-link
                    :href="auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')"
                    :active="request()->routeIs(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard')">
                    <i class="items-center flex fi fi-rr-objects-column text-gray-700 dark:text-gray-200 text-lg"></i>
                    <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Dashboard') }}</span>
                </x-nav-link>
            </li>
            @auth
            @if (Auth::user()->role === 'admin')
            

            <li x-data="{ open: false }" class="relative">
                <x-nav-link class="mb-2" href="#" @click.prevent="open = !open"
                    :active="request()->routeIs('siswa.index') || request()->routeIs('kelas.index') || request()->routeIs('rombel.index') || request()->routeIs('jurusan.index')">
                    <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                    <span class="hidden lg:block text-gray-700 dark:text-gray-300">Data Umum</span>
                    <svg :class="{'rotate-180': open}"
                        class="hidden lg:block w-4 h-4 ml-auto transform transition-transform duration-200 text-gray-600 dark:text-gray-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </x-nav-link>

                <!-- Desktop Dropdown -->
                <ul x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="-translate-y-3 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-3 opacity-0" 
                    class="pl-6 space-y-2 hidden lg:block">

                    <li>
                        <x-nav-link :href="route('siswa.index')" :active="request()->routeIs('siswa.index')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Data Siswa') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('kelas.index')" :active="request()->routeIs('kelas.index')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Data Kelas') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('jurusan.index')" :active="request()->routeIs('jurusan.index')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Data Jurusan') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('guru.index')" :active="request()->routeIs('guru.index')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Data Guru') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('rombel.index')" :active="request()->routeIs('rombel.index')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Data Rombel') }}</span>
                        </x-nav-link>
                    </li>
                </ul>

                <!-- Mobile Dropdown (Absolute positioned) -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.away="open = false"
                     class="lg:hidden absolute left-full top-0 ml-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                    <a href="{{ route('siswa.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-folder-open"></i>
                        <span>Data Siswa</span>
                    </a>
                    <a href="{{ route('kelas.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-folder-open"></i>
                        <span>Data Kelas</span>
                    </a>
                    <a href="{{ route('jurusan.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-folder-open"></i>
                        <span>Data Jurusan</span>
                    </a>
                    <a href="{{ route('guru.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-folder-open"></i>
                        <span>Data Guru</span>
                    </a>
                    <a href="{{ route('rombel.index') }}" 
                       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-folder-open"></i>
                        <span>Data Rombel</span>
                    </a>
                </div>
            </li>
            @endif
            @endauth

            <!-- TAMBAHKAN SETELAH MENU "DATA UMUM" DAN SEBELUM MENU "LAPORAN" -->
            <!-- Letakkan di sekitar baris 96 (setelah </li> penutup Data Umum) -->

            @auth
            @if (Auth::user()->role === 'admin')
            <!-- MENU AKADEMIK (BARU) -->
            <li x-data="{ open: false }" class="relative">
                <x-nav-link class="mb-2" href="#" @click.prevent="open = !open"
                    :active="request()->routeIs('admin.naikkelas.*') || request()->routeIs('admin.kelulusan.*') || request()->routeIs('admin.alumni.*')">
                    <i class="fi fi-rr-graduation-cap text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                    <span class="hidden lg:block text-gray-700 dark:text-gray-300">Akademik</span>
                    <svg :class="{'rotate-180': open}"
                        class="hidden lg:block w-4 h-4 ml-auto transform transition-transform duration-200 text-gray-600 dark:text-gray-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </x-nav-link>

                <!-- Desktop Dropdown -->
                <ul x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="-translate-y-3 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-3 opacity-0" 
                    class="pl-6 space-y-2 hidden lg:block">

                    <li>
                        <x-nav-link :href="route('admin.naikkelas.index')" :active="request()->routeIs('admin.naikkelas.*')">
                            <i class="fi fi-rr-arrow-up text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Naik Kelas') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.kelulusan.index')" :active="request()->routeIs('admin.kelulusan.*')">
                            <i class="fi fi-rr-diploma text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Kelulusan') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.alumni.index')" :active="request()->routeIs('admin.alumni.*')">
                            <i class="fi fi-rr-users text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                            <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Daftar Alumni') }}</span>
                        </x-nav-link>
                    </li>
                </ul>

                <!-- Mobile Dropdown (Absolute positioned) -->
                <div x-show="open" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    @click.away="open = false"
                    class="lg:hidden absolute left-full top-0 ml-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                    <a href="{{ route('admin.naikkelas.index') }}" 
                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-arrow-up"></i>
                        <span>Naik Kelas</span>
                    </a>
                    <a href="{{ route('admin.kelulusan.index') }}" 
                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-diploma"></i>
                        <span>Kelulusan</span>
                    </a>
                    <a href="{{ route('admin.alumni.index') }}" 
                    class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fi fi-rr-users"></i>
                        <span>Daftar Alumni</span>
                    </a>
                </div>
            </li>

            <li>
                <x-nav-link
                    :href="route('admin.monitoring.index')"
                    :active="request()->routeIs('admin.monitoring.*')">
                    <i class="fi fi-rr-signal-alt text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                    <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Monitoring Login') }}</span>
                </x-nav-link>
            </li>
            @endif
            @endauth

            <li x-data="{ open: false }" class="relative">
                <x-nav-link class="mb-2" href="#" @click.prevent="open = !open"
                    :active="request()->routeIs('admin.perKelas') || request()->routeIs('admin.perBulan') || request()->routeIs('user.perKelas') || request()->routeIs('user.perBulan')">
                    <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                    <span class="hidden lg:block text-gray-700 dark:text-gray-300">Laporan</span>
                    <svg :class="{'rotate-180': open}"
                        class="hidden lg:block w-4 h-4 ml-auto transform transition-transform duration-200 text-gray-600 dark:text-gray-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </x-nav-link>

                <!-- Desktop Dropdown -->
                <ul x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="-translate-y-3 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-3 opacity-0"
                    class="pl-6 space-y-2 hidden lg:block">

                    @if(Auth::user()->role === 'admin')
                        <li>
                            <x-nav-link :href="route('admin.perKelas')" :active="request()->routeIs('admin.perKelas')">
                                <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                                <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Laporan Perkelas') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('admin.perBulan')" :active="request()->routeIs('admin.perBulan')">
                                <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                                <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Laporan Perbulan') }}</span>
                            </x-nav-link>
                        </li>
                    @elseif(Auth::user()->role === 'user')
                        <li>
                            <x-nav-link :href="route('user.perKelas')" :active="request()->routeIs('user.perKelas')">
                                <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                                <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Laporan Perkelas') }}</span>
                            </x-nav-link>
                        </li>
                        <li>
                            <x-nav-link :href="route('user.perBulan')" :active="request()->routeIs('user.perBulan')">
                                <i class="fi fi-rr-folder-open text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                                <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Laporan Perbulan') }}</span>
                            </x-nav-link>
                        </li>
                    @endif
                </ul>

                <!-- Mobile Dropdown (Absolute positioned) -->
                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.away="open = false"
                     class="lg:hidden absolute left-full top-0 ml-2 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.perKelas') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fi fi-rr-folder-open"></i>
                            <span>Laporan Perkelas</span>
                        </a>
                        <a href="{{ route('admin.perBulan') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fi fi-rr-folder-open"></i>
                            <span>Laporan Perbulan</span>
                        </a>
                    @elseif(Auth::user()->role === 'user')
                        <a href="{{ route('user.perKelas') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fi fi-rr-folder-open"></i>
                            <span>Laporan Perkelas</span>
                        </a>
                        <a href="{{ route('user.perBulan') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fi fi-rr-folder-open"></i>
                            <span>Laporan Perbulan</span>
                        </a>
                    @endif
                </div>
            </li>

            <li>
                @if (Auth::user()->role === 'admin')
                    <x-nav-link
                        :href="route('admin.presensi.index')"
                        :active="request()->routeIs('admin.presensi.*')">
                        <i class="fi fi-rr-rectangle-list text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                        <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Presensi') }}</span>
                    </x-nav-link>
                @elseif(Auth::user()->role === 'user')
                    <x-nav-link
                        :href="route('user.presensi.index')"
                        :active="request()->routeIs('user.presensi.*')">
                        <i class="fi fi-rr-rectangle-list text-lg items-center flex text-gray-700 dark:text-gray-200"></i>
                        <span class="hidden lg:block text-gray-700 dark:text-gray-300">{{ __('Presensi') }}</span>
                    </x-nav-link>
                @endif
            </li>
        </ul>

        <hr class="my-4 w-full border-gray-200 dark:border-gray-700">

        <div class="space-y-2 w-full">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')" class="text-red-500 flex items-center justify-center lg:justify-start gap-4 
                           p-3 rounded hover:bg-gray-100 dark:hover:bg-slate-800 transition"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fi fi-rr-exit text-lg"></i>
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>

            <a href="/profile" class="flex items-center justify-center lg:justify-start gap-4 
                       text-gray-700 dark:text-gray-200 
                       p-3 rounded hover:bg-gray-100 dark:hover:bg-slate-800 transition">
                <i class="fi fi-rr-settings text-lg"></i>
                <span class="hidden lg:block">{{ __('Profile') }}</span>
            </a>
        </div>
    </div>
</aside>