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
        <div class="flex-1 flex items-center justify-center bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 p-6">
            <div class="w-full max-w-md bg-white/10 backdrop-blur-sm rounded-xl shadow-lg p-8">
                <!-- Logo -->
                <div class="flex justify-center mb-4">
                            <img src="{{ asset('logopesat.png') }}" alt="Logo Pesat" class="w-32 md:w-49 lg:w-56 mx-auto mb-6 drop-shadow-lg">

                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <h2 class="text-center text-white text-xl font-semibold mb-6">Silakan Login</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-white" />
                        <x-text-input id="name" class="block mt-1 w-full bg-white/20 text-white border border-white/30 rounded-md" type="name" name="name" :value="old('name')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-200" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="text-white" />
                        <x-text-input id="password" class="block mt-1 w-full bg-white/20 text-white border border-white/30 rounded-md" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="text-indigo-500 border-white/30 bg-white/10 focus:ring-white" name="remember">
                            <span class="ml-2 text-sm text-white">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-white hover:underline" href="{{ route('password.request') }}">
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
        <div class="hidden md:flex flex-1 items-center justify-center bg-white dark:bg-gray-900     ">
            <img src="{{ asset('login-ilustration.png') }}" alt="Logo Pesat" class="max-w-full h-auto object-contain">

            {{-- <img src="{{ asset(path: 'images/login-illustration.png') }}" alt="Login Illustration" class="max-w-full h-auto object-contain"> --}}
        </div>
    </div>
</x-guest-layout>
