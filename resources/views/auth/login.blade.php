<style>
    .fade-in {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-in.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginBox = document.getElementById('login-box');
        if (loginBox) {
            setTimeout(() => {
                loginBox.classList.add('show');
            }, 100); // bisa diatur delay jika mau
        }
    });
</script>

<x-guest-layout>
    <div class="w-screen h-screen flex flex-col md:flex-row">
        <!-- Left side: Login Form -->
        <div class="w-6/12 flex items-center justify-center bg-gray-100 p-6">
            <div class="w-full max-w-md ">
                <!-- Logo -->
                {{-- <div class="flex justify-center mb-4">
                            <img src="{{ asset('logopesat.png') }}" alt="Logo Pesat" class="w-32 md:w-49 lg:w-56 mx-auto mb-6 drop-shadow-lg">

                </div> --}}

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <h2 class="text-center text-neutral-700 text-3xl font-bold mb-6">Silakan Login</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <input placeholder="Nama" id="name" class="block placeholder:text-neutral-400 mt-1 w-full py-3 bg-white text-neutral-700 border border-white/30 rounded-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-200" />
                    </div>

                    <!-- Password -->

                    <div class="mt-4">
                        <input placeholder="Password" id="password" class="block placeholder:text-neutral-400 mt-1 w-full py-3 bg-white text-neutral-700 border border-white/30 rounded-lg" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-neutral-400 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right side: Illustration (Hidden on mobile) -->
        <div class="w-8/12 flex items-center justify-center bg-blue-500">
            <img src="{{ asset('login-page.webp') }}" alt="Logo Pesat" class="w-[50rem] h-auto object-contain">

            {{-- <img src="{{ asset(path: 'images/login-illustration.png') }}" alt="Login Illustration" class="max-w-full h-auto object-contain"> --}}
        </div>
    </div>
</x-guest-layout>
