
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


                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="csrf_token_placeholder">
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

                    <!-- Login Button -->
                    <button 
                        type="submit" 
                        id="login-btn"
                        class="btn-login w-full py-3 px-4 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-orange-500/20"
                    >
                        <span id="login-text">Masuk</span>
                        <span id="login-loading" class="hidden">
                            <svg class="animate-spin w-5 h-5 text-white inline mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </form>

        <!-- Right side: Illustration (Hidden on mobile) -->
        <div class="w-8/12 flex items-center justify-center bg-blue-500">
            <img src="{{ asset('login-page.webp') }}" alt="Logo Pesat" class="w-[50rem] h-auto object-contain">


            <!-- Additional Info Card -->
            <div class="mt-6 glass-card rounded-2xl p-6 text-center">
                <div class="flex items-center justify-center space-x-3 mb-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium">Informasi Login</h3>
                </div>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Gunakan nama pengguna dan kata sandi yang telah diberikan oleh sekolah. Jika mengalami kesulitan, silakan klik tombol WhatsApp di atas untuk menghubungi administrator sistem.
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fade in animation
            const loginBox = document.getElementById('login-box');
            if (loginBox) {
                setTimeout(() => {
                    loginBox.classList.add('show');
                }, 100);
            }

            // Form submission handling
            const form = document.querySelector('form');
            const loginBtn = document.getElementById('login-btn');
            const loginText = document.getElementById('login-text');
            const loginLoading = document.getElementById('login-loading');

            form.addEventListener('submit', function(e) {
                // Show loading state
                loginText.classList.add('hidden');
                loginLoading.classList.remove('hidden');
                loginBtn.disabled = true;
                loginBtn.classList.add('opacity-75');

                // For demo purposes - remove this in actual implementation
                setTimeout(() => {
                    loginText.classList.remove('hidden');
                    loginLoading.classList.add('hidden');
                    loginBtn.disabled = false;
                    loginBtn.classList.remove('opacity-75');
                }, 2000);
            });

            // Input field focus animations
            const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-105');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-105');
                });
            });
        });

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Mobile keyboard handling
        if (window.innerWidth <= 768) {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    setTimeout(() => {
                        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                });
            });
        }
    </script>

</body>
</html>