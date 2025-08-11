<aside class="fixed top-0 left-0 w-auto lg:w-72 z-40 bg-white min-h-screen">
    <div class="w-full px-5 py-10 flex flex-col">
        <img src="{{ asset('assets/smkpesat.webp')}}" alt="" class="w-24 mb-6">

        <ul class="space-y-2">
            
            <li>
                <x-nav-link :href="auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')"
                :active="request()->routeIs(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.dashboard')">

                <i class=" items-center flex fi fi-rr-objects-column text-lg"></i>
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
            <li>
                <a href="#" class="flex items-center gap-4 text-gray-700 p-3 rounded hover:bg-gray-100">
                    <i class="fi fi-rr-folder-open text-lg items-center flex"></i>
                    <span class="text-base hidden lg:block">Laporan</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center gap-4 text-gray-700 p-3 rounded hover:bg-gray-100">
                    <i class="fi fi-rr-user-pen text-lg items-center flex"></i>
                    <span class="text-base hidden lg:block">Manage Account</span>
                </a>
            </li>
        </ul>
        <hr class="my-4">
        <div class="space-y-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-red-500 flex items-center gap-4  p-3 rounded hover:bg-gray-100">
                    <i class="fi fi-rr-exit text-lg items-center flex"></i>
                    <span class="text-base hidden lg:block">{{ __('Log Out') }}</span>
                </a>



            </form>
            <a href="/profile" class="flex items-center gap-4 text-gray-700 p-3 rounded hover:bg-gray-100">
                <i class="fi fi-rr-settings text-lg items-center flex"></i>
                <span class="text-base hidden lg:block">{{ __('Profile') }}</span>
            </a>
        </div>
    </div>
</aside>