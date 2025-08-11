<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SMK PESAT XPRO</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-out {
            opacity: 0;
            transition: opacity 1s ease;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .fade-in.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-white">

    <!-- Splash Screen -->
    <div id="splash-screen" class="fixed inset-0 bg-white flex items-center justify-center z-50 transition-opacity duration-1000">
        <div class="flex flex-col items-center space-y-4">
            <img src="{{ asset('logopesat.png') }}" alt="Logo" class="w-26 h-24 animate-pulse">
            <p class="text-lg font-semibold text-gray-700">Memuat...</p>
        </div>
    </div>

    <!-- Konten Utama -->
    <div id="main-content" class="hidden">
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="w-full max-w-3xl mx-auto text-center flex flex-col space-y-8">
                
                <!-- Logo -->
                <div class="flex justify-center fade-in" id="logo">
                    <img src="{{ asset('logopesat.png') }}" alt="Logo Pesat" class="w-32 md:w-44 lg:w-52 mx-auto drop-shadow-lg">
                </div>

                <!-- Judul -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold leading-snug sm:leading-snug md:leading-tight fade-in" id="title">
                    Selamat Datang di<br>
                    Sistem Absensi<br>
                    <span class="text-orange-400">SMK Informatika Pesat</span>
                </h1>

                <!-- Tombol -->
                <div class="flex flex-col md:flex-row items-center justify-center gap-4 mt-4 fade-in" id="buttons">
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded-md transition-all">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border border-indigo-600 text-indigo-600 hover:bg-indigo-50 px-6 py-2 rounded-md transition-all">
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Script Transisi -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const splash = document.getElementById('splash-screen');
                splash.classList.add('fade-out');

                setTimeout(() => {
                    splash.style.display = 'none';

                    const mainContent = document.getElementById('main-content');
                    mainContent.classList.remove('hidden');

                    // Tambahkan efek fade-in bertahap
                    setTimeout(() => document.getElementById('logo').classList.add('show'), 100);
                    setTimeout(() => document.getElementById('title').classList.add('show'), 400);
                    setTimeout(() => document.getElementById('buttons').classList.add('show'), 700);

                }, 1000); // tunggu splash hilang
            }, 2000); // splash tampil selama 2 detik
        });
    </script>

</body>
</html>
