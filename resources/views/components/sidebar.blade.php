<aside class="fixed top-0 left-0 w-16 lg:w-72 z-40 bg-white min-h-screen transition-all duration-300">
    <div class="w-full px-2 lg:px-5 py-10 flex flex-col items-center lg:items-start">
        <img src="{{ asset('assets/smkpesat.webp')}}" alt="" class="w-10 lg:w-24 mb-6">

        <ul class="space-y-2 w-full">
            <li>
                <x-nav-link
                    :href="auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')"
                    :active="request()->routeIs(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard')">
                    <i class="items-center flex fi fi-rr-objects-column text-lg"></i>
                    <span class="hidden lg:block">{{ __('Dashboard') }}</span>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link :href="auth()->user()->role === 'admin' ? route('admin.absensi') : route('user.absensi')"
                    :active="request()->routeIs(auth()->user()->role === 'admin' ? 'admin.absensi' : 'user.absensi')">
                    <i class="fi fi-rr-rectangle-list text-lg items-center flex"></i>
                    <span class="hidden lg:block">{{ __('Absensi') }}</span>
                </x-nav-link>
            </li>

            @auth
            @if (Auth::user()->role === 'admin')
            <li x-data="{ open: false }">
                <x-nav-link class="mb-2" href="#" @click.prevent="open = !open"
                    :active="request()->routeIs('admin.perKelas') || request()->routeIs('admin.perBulan')">
                    <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                    <span class="hidden lg:block">Laporan</span>
                    <svg :class="{'rotate-180': open}" class="hidden lg:block w-4 h-4 ml-auto transform transition-transform duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </x-nav-link>

                <ul x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="-translate-y-3 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-3 opacity-0"
                    class="pl-6 space-y-2 hidden lg:block">
                    <li>
                        <x-nav-link :href="route('admin.perKelas')" :active="request()->routeIs('admin.perKelas')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                            <span class="hidden lg:block">{{ __('Laporan Perkelas') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :active="request()->routeIs('admin.perBulan')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                            <span class="hidden lg:block">{{ __('Laporan Perbulan') }}</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>
            <li x-data="{ open: false }">
                <x-nav-link class="mb-2" href="#" @click.prevent="open = !open"
                    :active="request()->routeIs('admin.siswabaru') || request()->routeIs('admin.kelasbaru')">
                    <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                    <span class="hidden lg:block">Tambah</span>
                    <svg :class="{'rotate-180': open}" class="hidden lg:block w-4 h-4 ml-auto transform transition-transform duration-200" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </x-nav-link>

                <ul x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="-translate-y-3 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-3 opacity-0"
                    class="pl-6 space-y-2 hidden lg:block">
                    <li>
                        <x-nav-link :href="route('admin.siswabaru')" :active="request()->routeIs('admin.siswabaru')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                            <span class="hidden lg:block">{{ __('Tambah Siswa') }}</span>
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.kelasbaru')" :active="request()->routeIs('admin.kelasbaru')">
                            <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                            <span class="hidden lg:block">{{ __('Tambah Kelas') }}</span>
                        </x-nav-link>
                    </li>
                </ul>
            </li>
            @endif
            @endauth

            <li>
                <a href="#" class="flex items-center justify-center lg:justify-start gap-4 text-gray-700 p-3 rounded hover:bg-gray-100">
                    <i class="fi fi-rr-user-pen text-lg"></i>
                    <span class="hidden lg:block">Manage Account</span>
                </a>
            </li>
        </ul>

        <hr class="my-4 w-full">

        <div class="space-y-2 w-full">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-red-500 flex items-center justify-center lg:justify-start gap-4 p-3 rounded hover:bg-gray-100">
                    <i class="fi fi-rr-exit text-lg"></i>
                    <span class="hidden lg:block">{{ __('Log Out') }}</span>
                </a>
            </form>

            <a href="/profile" class="flex items-center justify-center lg:justify-start gap-4 text-gray-700 p-3 rounded hover:bg-gray-100">
                <i class="fi fi-rr-settings text-lg"></i>
                <span class="hidden lg:block">{{ __('Profile') }}</span>
            </a>
        </div>
    </div>
</aside>
