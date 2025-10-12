<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center animate-pulse shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-3xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent leading-tight">
                        {{ __('Monitoring Login Real-time') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 font-medium">
                        Pantau aktivitas guru yang sedang login ✨
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl px-4 py-2 shadow-lg border border-white/20 dark:border-gray-700/50">
                    <div class="flex items-center gap-2">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-gray-200">Live</span>
                        <span id="last-update" class="text-xs text-gray-500 dark:text-gray-400"></span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-green-50 via-white to-emerald-50 dark:from-gray-900 dark:via-gray-800 dark:to-emerald-900 min-h-screen">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Online -->
                <div class="bg-gradient-to-br from-emerald-600 via-green-500 to-teal-600 text-white rounded-3xl shadow-2xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-emerald-100 text-xs font-bold uppercase tracking-wider mb-1">Sedang Online</p>
                            <h3 id="stat-online" class="text-4xl font-black">0</h3>
                        </div>
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-sm font-semibold">Update otomatis</span>
                    </div>
                </div>

                <!-- Total Guru -->
                <div class="bg-gradient-to-br from-blue-600 via-cyan-500 to-teal-600 text-white rounded-3xl shadow-2xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-1">Guru Online</p>
                            <h3 id="stat-guru" class="text-4xl font-black">0</h3>
                        </div>
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-semibold opacity-90">Pengajar</div>
                </div>

                <!-- Total Users -->
                <div class="bg-gradient-to-br from-slate-700 via-gray-600 to-slate-800 text-white rounded-3xl shadow-2xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-slate-300 text-xs font-bold uppercase tracking-wider mb-1">Total Pengguna</p>
                            <h3 id="stat-total" class="text-4xl font-black">0</h3>
                        </div>
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-semibold opacity-90">Terdaftar</div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-t-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 p-4">
                <div class="flex flex-wrap gap-2">
                    <button onclick="switchTab('online')" id="tab-online" class="tab-button active px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <i class="fi fi-rr-signal-alt mr-2"></i>
                        Sedang Online
                    </button>
                    <button onclick="switchTab('history')" id="tab-history" class="tab-button px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <i class="fi fi-rr-time-past mr-2"></i>
                        Riwayat Login
                    </button>
                </div>
            </div>

            <!-- Tab Content: Online Users -->
            <div id="content-online" class="tab-content">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-b-3xl shadow-2xl border-x border-b border-white/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Pengguna</th>
                                    <th class="px-6 py-4 font-bold">Role</th>
                                    <th class="px-6 py-4 font-bold">Halaman Saat Ini</th>
                                    <th class="px-6 py-4 font-bold">IP Address</th>
                                    <th class="px-6 py-4 font-bold">Browser</th>
                                    <th class="px-6 py-4 font-bold">Login</th>
                                    <th class="px-6 py-4 font-bold">Aktivitas Terakhir</th>
                                    <th class="px-6 py-4 font-bold">Durasi</th>
                                </tr>
                            </thead>
                            <tbody id="online-users-table" class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                                            <p class="text-gray-500 dark:text-gray-400">Memuat data...</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab Content: History -->
            <div id="content-history" class="tab-content hidden">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-b-3xl shadow-2xl border-x border-b border-white/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Filter -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-4 items-center">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Filter Role:</label>
                            <select id="filter-role" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-emerald-500">
                                <option value="all">Semua</option>
                                <option value="admin">Admin</option>
                                <option value="user">Guru</option>
                            </select>
                            <button onclick="loadHistory()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition-all">
                                <i class="fi fi-rr-refresh mr-2"></i>
                                Refresh
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                <tr>
                                    <th class="px-6 py-4 font-bold">Pengguna</th>
                                    <th class="px-6 py-4 font-bold">Role</th>
                                    <th class="px-6 py-4 font-bold">IP Address</th>
                                    <th class="px-6 py-4 font-bold">Browser</th>
                                    <th class="px-6 py-4 font-bold">Login</th>
                                    <th class="px-6 py-4 font-bold">Logout</th>
                                    <th class="px-6 py-4 font-bold">Durasi</th>
                                    <th class="px-6 py-4 font-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody id="history-table" class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                                            <p class="text-gray-500 dark:text-gray-400">Memuat data...</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <!-- Pagination akan di-generate oleh JavaScript -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .tab-button {
            background: transparent;
            color: #6b7280;
        }
        
        .tab-button.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .tab-button:hover:not(.active) {
            background: #f3f4f6;
        }
        
        .dark .tab-button:hover:not(.active) {
            background: #374151;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-online {
            background: #d1fae5;
            color: #065f46;
        }
        
        .status-offline {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .dark .status-online {
            background: rgba(16, 185, 129, 0.2);
            color: #6ee7b7;
        }
        
        .dark .status-offline {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }
    </style>

    <script>
        let updateInterval;
        let currentPage = 1;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadOnlineUsers();
            startAutoUpdate();
            
            // Update activity setiap 2 menit
            setInterval(updateUserActivity, 120000);
        });

        // Switch Tab
        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('tab-' + tab).classList.add('active');
            
            // Update content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById('content-' + tab).classList.remove('hidden');
            
            // Load data
            if (tab === 'online') {
                loadOnlineUsers();
                startAutoUpdate();
            } else if (tab === 'history') {
                stopAutoUpdate();
                loadHistory();
            }
        }

        // Load Online Users
        function loadOnlineUsers() {
            fetch('/admin/monitoring/api/active-users')
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        updateStats(result.stats);
                        renderOnlineUsers(result.data);
                        updateTimestamp(result.timestamp);
                    }
                })
                .catch(error => {
                    console.error('Error loading online users:', error);
                });
        }

        // Render Online Users
        function renderOnlineUsers(users) {
            const tbody = document.getElementById('online-users-table');
            
            if (!users || users.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-500 dark:text-gray-400 mb-1">Tidak ada pengguna online</h4>
                                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada yang login saat ini</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            tbody.innerHTML = users.map(user => {
                const name = user.name || 'Unknown';
                const initial = name.charAt(0).toUpperCase();
                const role = user.role || 'unknown';
                const isAdmin = role === 'admin';
                
                return `
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-green-50/50 dark:hover:from-gray-700/50 dark:hover:to-gray-600/50 transition-all duration-300">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">${initial}</span>
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></div>
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">${name}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ${isAdmin ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'}">
                                ${user.role_badge || 'Unknown'}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    ${user.current_page || 'Unknown'}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-mono text-sm">${user.ip_address || '-'}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">${user.browser || 'Unknown'} (${user.device || 'Unknown'})</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            <div class="text-sm">${user.login_at || '-'}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${user.login_at_readable || '-'}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            <div class="text-sm">${user.last_activity || '-'}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${user.last_activity_readable || '-'}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-semibold">${user.duration || '-'}</td>
                    </tr>
                `;
            }).join('');
        }

        // Load History
        function loadHistory(page = 1) {
            const role = document.getElementById('filter-role').value;
            const tbody = document.getElementById('history-table');
            
            // Show loading state
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                            <p class="text-gray-500 dark:text-gray-400">Memuat data riwayat...</p>
                        </div>
                    </td>
                </tr>
            `;
            
            fetch(`/admin/monitoring/api/login-history?page=${page}&role=${role}&per_page=10`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        renderHistory(result.data);
                        renderPagination(result.pagination);
                    } else {
                        showError('Gagal memuat riwayat: ' + (result.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error loading history:', error);
                    showError('Gagal memuat riwayat login: ' + error.message);
                });
        }

        // Render History
        function renderHistory(history) {
            const tbody = document.getElementById('history-table');
            
            if (!history || history.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-500 dark:text-gray-400 mb-1">Tidak ada riwayat</h4>
                                    <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada data riwayat login</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }
            
            try {
                tbody.innerHTML = history.map(item => `
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300">
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">${item.user_name || 'Unknown'}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ${item.role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'}">
                                ${item.role_badge || 'Unknown'}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-mono text-sm">${item.ip_address || '-'}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">${item.browser || 'Unknown'}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 text-sm">${item.login_at || '-'}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 text-sm">${item.logout_at || '-'}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-semibold">${item.duration || '-'}</td>
                        <td class="px-6 py-4">
                            <span class="status-badge ${item.status === 'online' ? 'status-online' : 'status-offline'}">
                                ${item.status_badge || 'Unknown'}
                            </span>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error rendering history:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="text-red-600 dark:text-red-400">
                                Error: ${error.message}
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Render Pagination
        function renderPagination(pagination) {
            const container = document.getElementById('pagination');
            
            if (!container) return;
            
            if (!pagination || pagination.last_page <= 1) {
                container.innerHTML = '';
                return;
            }
            
            let pages = '';
            for (let i = 1; i <= pagination.last_page; i++) {
                pages += `
                    <button onclick="loadHistory(${i})" class="px-4 py-2 ${i === pagination.current_page ? 'bg-emerald-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'} rounded-lg font-semibold transition-all hover:scale-105">
                        ${i}
                    </button>
                `;
            }
            
            container.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Menampilkan ${(pagination.current_page - 1) * pagination.per_page + 1} - ${Math.min(pagination.current_page * pagination.per_page, pagination.total)} dari ${pagination.total} data
                    </div>
                    <div class="flex gap-2">
                        ${pages}
                    </div>
                </div>
            `;
        }

        // Update Stats
        function updateStats(stats) {
            const elements = {
                'stat-online': stats.total_online,
                'stat-admin': stats.total_admin,
                'stat-guru': stats.total_guru,
                'stat-total': stats.total_users
            };
            
            Object.keys(elements).forEach(id => {
                const el = document.getElementById(id);
                if (el) el.textContent = elements[id] || 0;
            });
        }

        // Update Timestamp
        function updateTimestamp(timestamp) {
            const el = document.getElementById('last-update');
            if (el) {
                el.textContent = timestamp || '';
            }
        }

        // Update User Activity (keep-alive)
        function updateUserActivity() {
            fetch('/admin/monitoring/api/update-activity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(error => {
                console.error('Error updating activity:', error);
            });
        }

        // Start Auto Update
        function startAutoUpdate() {
            stopAutoUpdate();
            updateInterval = setInterval(() => {
                loadOnlineUsers();
            }, 1000); // Update setiap 5 detik
        }

        // Stop Auto Update
        function stopAutoUpdate() {
            if (updateInterval) {
                clearInterval(updateInterval);
            }
        }

        // Show Error
        function showError(message) {
            console.error(message);
            const tbody = document.getElementById('history-table');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="text-red-600 dark:text-red-400 font-semibold">
                                ${message}
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            stopAutoUpdate();
        });

        // Event listener untuk filter role
        document.addEventListener('DOMContentLoaded', function() {
            const filterRole = document.getElementById('filter-role');
            if (filterRole) {
                filterRole.addEventListener('change', function() {
                    loadHistory(1);
                });
            }
        });
    </script>
</x-app-layout>