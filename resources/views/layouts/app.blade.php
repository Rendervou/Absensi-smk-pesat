<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="user-role" content="{{ auth()->check() ? auth()->user()->role : '' }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <link rel="icon" href="{{ asset('assets/smkpesat.webp') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons@3.3.1/css/all/all.min.css" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('components.sidebar')

            <!-- Page Content -->
            <main class="ml-20 lg:ml-72">
                {{ $slot }}
            </main>
        </div>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            let inactivityTimer;
            let warningTimer;
            let warningShown = false;

            // ✅ Cek role dengan aman (hindari error jika belum login)
            @auth
                const isUserRole = '{{ Auth::user()->role }}' === 'user';
            @else
                const isUserRole = false;
            @endauth

            if (isUserRole) {
                // SINKRONKAN dengan middleware: 10 menit auto-logout (HANYA UNTUK GURU)
                const AUTO_LOGOUT_TIME = 10 * 60 * 1000; // 10 menit
                const WARNING_TIME = 8 * 60 * 1000; // Warning 8 menit sebelum logout

                function resetInactivityTimer() {
                    clearTimeout(inactivityTimer);
                    clearTimeout(warningTimer);
                    warningShown = false;
                    
                    // Warning 2 menit sebelum logout
                    warningTimer = setTimeout(() => {
                        if (!warningShown) {
                            warningShown = true;
                            const userConfirm = confirm('⚠️ PERINGATAN!\n\nSesi Anda akan berakhir dalam 2 menit karena tidak ada aktivitas.\n\nKlik OK untuk tetap login, atau Cancel untuk logout sekarang.');
                            
                            if (userConfirm) {
                                resetInactivityTimer();
                                
                                fetch('/admin/monitoring/api/update-activity', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                });
                            } else {
                                logoutUser();
                            }
                        }
                    }, WARNING_TIME);
                    
                    // Auto logout setelah 10 menit
                    inactivityTimer = setTimeout(() => {
                        alert('⏰ Sesi Anda telah berakhir karena tidak aktif selama 10 menit.\n\nAnda akan diarahkan ke halaman login.');
                        logoutUser();
                    }, AUTO_LOGOUT_TIME);
                }

                // Fungsi logout dengan form POST
                function logoutUser() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/logout';
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrfInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }

                // Reset timer saat ada aktivitas
                document.addEventListener('mousemove', resetInactivityTimer);
                document.addEventListener('keypress', resetInactivityTimer);
                document.addEventListener('click', resetInactivityTimer);
                document.addEventListener('scroll', resetInactivityTimer);
                document.addEventListener('touchstart', resetInactivityTimer);

                // Initialize
                resetInactivityTimer();
            } else {
                console.log('Admin tidak kena auto-logout');
            }

            // Update activity setiap 2 menit (untuk semua role)
            setInterval(function() {
                fetch('/admin/monitoring/api/update-activity', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).catch(error => {
                    console.log('Keep-alive failed:', error);
                });
            }, 2 * 60 * 1000);
        </script>
        </body>
        </html>
    </body>
</html>