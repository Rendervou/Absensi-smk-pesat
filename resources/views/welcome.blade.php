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
        * {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e40af 0%, #f97316 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #f97316, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .fade-out {
            opacity: 0;
            transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(0.95);
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

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .pulse-glow {
            animation: pulse-glow 2.5s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { 
                box-shadow: 0 0 30px rgba(249, 115, 22, 0.3);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 50px rgba(249, 115, 22, 0.6), 0 0 70px rgba(249, 115, 22, 0.3);
                transform: scale(1.05);
            }
        }

        .dark-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(249, 115, 22, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 50%);
        }

        .splash-logo {
            animation: splash-logo 2s ease-in-out;
        }

        @keyframes splash-logo {
            0% { transform: scale(0) rotate(180deg); opacity: 0; }
            50% { transform: scale(1.1) rotate(0deg); opacity: 1; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="min-h-screen bg-slate-900 dark-pattern text-white">

    <!-- Splash Screen -->
    <div id="splash-screen" class="fixed inset-0 gradient-bg flex items-center justify-center z-50 transition-all duration-1000">
        <div class="flex flex-col items-center space-y-8 text-center">
            <div class="relative splash-logo">
                <div class="w-36 h-36 bg-white/10 backdrop-blur-sm rounded-3xl flex items-center justify-center pulse-glow border border-white/20">
                    <img src="{{ asset('logopesat.png') }}" alt="Logo SMK PESAT" class="w-24 h-20 object-contain">
                </div>
            </div>
            <div class="text-white space-y-4">
                <h2 class="text-4xl font-bold tracking-tight">SMK PESAT</h2>
                <p class="text-orange-200 font-medium text-lg">Sistem Absensi Digital</p>
                <div class="flex items-center justify-center space-x-2 pt-4">
                    <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                    <div class="w-3 h-3 bg-white rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                    <div class="w-3 h-3 bg-white rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                </div>
                <p class="text-white/80 text-sm">Memuat sistem...</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="hidden">
        <!-- Hero Section -->
        <main class="min-h-screen flex items-center justify-center px-4 py-20">
            <div class="max-w-4xl mx-auto text-center space-y-12">
                
                <!-- Logo -->
                <div class="fade-in" id="logo">
                    <div class="relative inline-block">
                        <img src="{{ asset('logopesat.png') }}" alt="Logo Pesat" class="w-32 md:w-40 lg:w-48 mx-auto drop-shadow-2xl floating-animation">
                        <div class="absolute -inset-6 bg-gradient-to-r from-orange-400/20 to-blue-500/20 rounded-full blur-2xl"></div>
                    </div>
                </div>

                <!-- Title -->
                <div class="fade-in space-y-6" id="title">
                    <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold leading-tight">
                        <span class="block text-white mb-4">Selamat Datang di</span>
                        <span class="block text-white mb-4">Sistem Absensi</span>
                        <span class="block gradient-text">SMK Informatika Pesat</span>
                    </h1>
                    <p class="text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed">
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

                <!-- Simple Info -->
                
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
            // Splash screen animation
            setTimeout(function () {
                const splash = document.getElementById('splash-screen');
                splash.classList.add('fade-out');

                setTimeout(() => {
                    splash.style.display = 'none';
                    const mainContent = document.getElementById('main-content');
                    mainContent.classList.remove('hidden');

                    // Staggered fade-in animations
                    const elements = [
                        { id: 'logo', delay: 200 },
                        { id: 'title', delay: 500 },
                        { id: 'buttons', delay: 800 },
                        { id: 'info', delay: 1100 }
                    ];

                    elements.forEach(({ id, delay }) => {
                        setTimeout(() => {
                            const element = document.getElementById(id);
                            if (element) element.classList.add('show');
                        }, delay);
                    });

                }, 1000);
            }, 2000);

            // Add loading state to buttons
            document.querySelectorAll('a[href*="login"], a[href*="register"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    const originalHTML = this.innerHTML;
                    this.innerHTML = `
                        <svg class="animate-spin w-6 h-6 text-current inline mr-3" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memuat...
                    `;
                    this.classList.add('opacity-75');
                    
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('opacity-75');
                    }, 1500);
                });
            });
        });
    </script>

</body>
</html>