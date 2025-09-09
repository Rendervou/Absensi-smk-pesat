<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SMK PESAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        .dark-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
        }

        .fade-in { opacity: 0; transform: translateY(30px); transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
        .fade-in.show { opacity: 1; transform: translateY(0); }

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

        .btn-register {
            background: linear-gradient(135deg, #f97316, #ea580c);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(249, 115, 22, 0.4);
        }

        .floating-logo { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)} }
    </style>
</head>
<body class="min-h-screen py-10 bg-slate-900 dark-pattern">

    <!-- Back to Home -->
    <div class="absolute top-4 left-4 z-10">
        <a href="/" class="inline-flex items-center space-x-2 text-white/80 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span class="text-sm font-medium">Kembali ke Beranda</span>
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            
            <!-- Register Card -->
            <div id="register-box" class="glass-card rounded-3xl shadow-2xl p-8 fade-in">
                
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-blue-600 rounded-2xl flex items-center justify-center floating-logo">
                            <img src="{{ asset('logopesat.png') }}" alt="Logo SMK PESAT" class="w-12 h-10 object-contain">
                        </div>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">Daftar Akun</h1>
                    <p class="text-slate-300 text-sm">Buat akun untuk mengakses Sistem Absensi SMK PESAT</p>
                </div>

                <!-- Error & Status -->
                <div class="mb-4">
                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Register Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-white">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                               class="input-field block w-full px-3 py-3 text-white placeholder-slate-400 rounded-xl focus:outline-none"
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-white">Kata Sandi</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="input-field block w-full px-3 py-3 text-white placeholder-slate-400 rounded-xl focus:outline-none"
                               placeholder="Masukkan kata sandi">
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-medium text-white">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="input-field block w-full px-3 py-3 text-white placeholder-slate-400 rounded-xl focus:outline-none"
                               placeholder="Ulangi kata sandi">
                    </div>

                    <!-- Register Button -->
                    <button type="submit" class="btn-register w-full py-3 px-4 text-white font-semibold rounded-xl transition-all focus:outline-none focus:ring-4 focus:ring-orange-500/20">
                        Daftar
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-slate-900/90 px-4 text-slate-400">Sudah punya akun?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-slate-400 text-sm">
                        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-medium transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const box = document.getElementById('register-box');
            if (box) setTimeout(() => box.classList.add('show'), 100);
        });
    </script>
</body>
</html>
