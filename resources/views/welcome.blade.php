<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK PESAT XPRO - Sistem Absensi</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }

        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #f97316 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #f97316, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316, #ea580c);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(249, 115, 22, 0.5);
        }

        .btn-secondary {
            border: 2px solid #3b82f6;
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
            backdrop-filter: blur(10px);
        }
        .btn-secondary:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.4);
        }

        .dark-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
        }

        /* Animasi logo masuk */
        .splash-logo {
            animation: splash-logo 2.5s ease-in-out forwards;
        }
        @keyframes splash-logo {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.2); opacity: 1; }
            70% { transform: scale(0.9); }
            100% { transform: scale(1) translateY(-250px); opacity: 1; }
        }

        /* Floating animation dari posisi akhir */
        .floating-animation {
            animation: float 6s ease-in-out infinite;
            animation-delay: 2.5s; /* mulai setelah splash-logo selesai */
        }
        @keyframes float {
            0%, 100% { transform: scale(1) translateY(-250px); }
            50% { transform: scale(1.02) translateY(-270px); }
        }

        
    </style>
</head>
<body class="min-h-screen dark:bg-slate-900 bg-slate-100 dark-pattern dark:text-gray-900 text-white overflow-hidden">

    <!-- Splash + Logo (akan pindah ke atas) -->
    <div id="splash-logo-container" class="fixed inset-0 flex items-center justify-center z-50">
        <div id="logo-box" class="w-44 h-44 dark:bg-white/30 dark:backdrop-blur-sm rounded-3xl flex items-center justify-center dark:border border-white/20 splash-logo">
            <img src="{{ asset('logopesat.png') }}" alt="Logo SMK PESAT" class="w-32 h-28 object-contain">
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="hidden">
        <!-- Hero Section -->
        <main class="min-h-screen flex items-center justify-center px-4 py-20 relative">
            <div class="max-w-4xl mx-auto text-center space-y-12">
                
                <!-- Title -->
                <div class="fade-in" id="title">
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight mt-40">
                        <span class="block text-gray-900 dark:text-white mb-4">Selamat Datang di</span>
                        <span class="block text-gray-900 dark:text-white mb-4">Sistem Absensi</span>
                        <span class="block text-gray-900 gradient-text">SMK Informatika Pesat</span>
                    </h1>
                    <p class="text-xl dark:text-slate-300 text-slate-900 max-w-3xl mx-auto leading-relaxed">
                        Platform absensi digital yang modern dan efisien untuk mendukung proses pembelajaran di SMK Informatika Pesat.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="fade-in flex flex-col sm:flex-row gap-8 justify-center items-center" id="buttons">
                    <a href="{{ route('login') }}" class="btn-primary text-white font-bold px-12 py-5 rounded-2xl transition-all duration-300 inline-flex items-center justify-center space-x-4 text-xl shadow-2xl min-w-[200px]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Login</span>
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary font-bold px-12 py-5 rounded-2xl transition-all duration-300 inline-flex items-center justify-center space-x-4 text-xl shadow-2xl min-w-[200px]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>Daftar Akun</span>
                        </a>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-800/50 border-t border-slate-700 py-8">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">                   
                    <span class="font-bold text-xl text-white">SMK PESAT</span>
                </div>
                <p class="text-slate-400 mb-4">© 2024 SMK Informatika Pesat. Semua hak cipta dilindungi.</p>
                <p class="text-slate-500 text-sm">Sistem Absensi Digital - Teknologi untuk Pendidikan</p>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            const mainContent = document.getElementById('main-content');
            mainContent.classList.remove('hidden');

            // Fade-in teks & tombol
            const elements = [
                { id: 'title', delay: 500 },
                { id: 'buttons', delay: 1000 }
            ];
            elements.forEach(({ id, delay }) => {
                setTimeout(() => {
                    const element = document.getElementById(id);
                    if (element) element.classList.add('show');
                }, delay);
            });

        }, 2500);
    });
    </script>

</body>
</html>
