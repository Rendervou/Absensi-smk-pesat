<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMK PESAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #f97316 100%);
        }

        .dark-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #f97316, #ea580c);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4);
        }

        .btn-whatsapp {
            background: linear-gradient(135deg, #25d366, #128c7e);
            box-shadow: 0 8px 20px rgba(37, 211, 102, 0.3);
        }

        .btn-whatsapp:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(37, 211, 102, 0.4);
            background: linear-gradient(135deg, #128c7e, #075e54);
        }

        .floating-logo {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .pulse-glow {
            animation: pulse-glow 3s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 20px rgba(249, 115, 22, 0.3);
            }
            50% { 
                box-shadow: 0 0 30px rgba(249, 115, 22, 0.5), 0 0 40px rgba(249, 115, 22, 0.2);
            }
        }

        .whatsapp-bounce {
            animation: whatsapp-bounce 2s infinite;
        }

        @keyframes whatsapp-bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-3px);
            }
            60% {
                transform: translateY(-1px);
            }
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .mobile-padding {
                padding: 1rem;
            }
            
            .mobile-card {
                margin: 1rem;
                min-height: auto;
            }
        }

        /* Custom scrollbar for mobile */
        ::-webkit-scrollbar {
            width: 4px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.1);
        }
        
        ::-webkit-scrollbar-thumb {
            background: rgba(249, 115, 22, 0.5);
            border-radius: 2px;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-900 dark-pattern">

    <!-- Back to Home Button -->
    <div class="absolute top-4 left-4 z-10">
        <a href="/" class="inline-flex items-center space-x-2 text-white/80 hover:text-white transition-colors duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="text-sm font-medium">Kembali ke Beranda</span>
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center mobile-padding">
        <div class="w-full max-w-md">
            
            <!-- Login Card -->
            <div id="login-box" class="glass-card rounded-3xl shadow-2xl p-8 mobile-card fade-in">
                
                <!-- Header Section -->
                <div class="text-center mb-8">
                    <!-- Logo -->
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-blue-600 rounded-2xl flex items-center justify-center pulse-glow floating-logo">
                                <img src="{{ asset('logopesat.png') }}" alt="Logo SMK PESAT" class="w-12 h-10 object-contain">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-2xl font-bold text-white mb-2">Selamat Datang</h1>
                    <p class="text-slate-300 text-sm">Masuk ke Sistem Absensi SMK PESAT</p>
                </div>

                <!-- Session Status -->
                <div class="mb-4">
                    @if (session('status'))
                        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Name Field -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-white">
                            Nama Pengguna
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}"
                                required 
                                autofocus
                                autocomplete="username"
                                class="input-field block w-full pl-10 pr-3 py-3 text-white placeholder-slate-400 rounded-xl focus:outline-none focus:ring-0 transition-all duration-300 @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama pengguna"
                            >
                        </div>
                        @error('name')
                            <div class="text-red-300 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-white">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required
                                autocomplete="current-password"
                                class="input-field block w-full pl-10 pr-12 py-3 text-white placeholder-slate-400 rounded-xl focus:outline-none focus:ring-0 transition-all duration-300 @error('password') border-red-500 @enderror"
                                placeholder="Masukkan kata sandi"
                            >
                            <!-- Toggle Password Visibility -->
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eye-icon" class="w-5 h-5 text-slate-400 hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-red-300 text-sm mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input 
                                id="remember_me" 
                                name="remember" 
                                type="checkbox" 
                                class="w-4 h-4 text-orange-500 bg-white/10 border-white/30 rounded focus:ring-orange-500 focus:ring-2"
                            >
                            <span class="ml-2 text-sm text-slate-300">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 transition-colors duration-300">
                                Lupa kata sandi?
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

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-slate-900/90 px-4 text-slate-400">Butuh bantuan?</span>
                    </div>
                </div>

                <!-- WhatsApp Contact Button -->
                <div class="mb-6">
                    <a 
                        href="https://wa.me/6285883490975?text=Halo%20Admin%2C%20saya%20mengalami%20kesulitan%20dalam%20login%20ke%20sistem%20absensi%20SMK%20PESAT.%20Mohon%20bantuannya."
                        target="_blank"
                        class="btn-whatsapp w-full py-3 px-4 text-white font-semibold rounded-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-green-500/20 flex items-center justify-center space-x-3 group"
                    >
                        <div class="whatsapp-bounce">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                        </div>
                        <span>Hubungi Admin WhatsApp</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </a>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-slate-400 text-sm">
                        Belum memiliki akun? 
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors duration-300">
                                Daftar di sini
                            </a>
                        @endif
                    </p>
                </div>
            </div>

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
                // Show loading state immediately
                loginText.classList.add('hidden');
                loginLoading.classList.remove('hidden');
                loginBtn.disabled = true;
                loginBtn.classList.add('opacity-75');
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