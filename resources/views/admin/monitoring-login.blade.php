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
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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
            
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-t-3xl shadow-2xl border border-white/50 dark:border-gray-700/50 p-4">
                <div class="flex flex-wrap gap-2">
                    <button onclick="switchTab('online')" id="tab-online" class="tab-button active px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        Sedang Online
                    </button>
                    <button onclick="switchTab('history')" id="tab-history" class="tab-button px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        Riwayat Login
                    </button>
                </div>
            </div>

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
                                    <th class="px-6 py-4 font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="online-users-table" class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center">
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

            <div id="content-history" class="tab-content hidden">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-b-3xl shadow-2xl border-x border-b border-white/50 dark:border-gray-700/50 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-4 items-center">
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">Filter Role:</label>
                            <select id="filter-role" class="px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-emerald-500">
                                <option value="all">Semua</option>
                                <option value="admin">Admin</option>
                                <option value="user">Guru</option>
                            </select>
                            <button onclick="loadHistory()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition-all">
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
                                    <th class="px-6 py-4 font-bold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="history-table" class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                                            <p class="text-gray-500 dark:text-gray-400">Memuat data...</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="pagination" class="p-6 border-t border-gray-200 dark:border-gray-700"></div>
                </div>
            </div>

        </div>
    </div>

    <div id="modal-user-detail" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-600 to-green-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Detail & History Akun</h3>
                        <p class="text-xs text-emerald-100" id="modal-user-name">Loading...</p>
                    </div>
                </div>
                <button onclick="closeUserDetailModal()" class="text-white hover:bg-white/20 rounded-xl p-2 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto max-h-[calc(90vh-80px)]">
                <div id="modal-content" class="p-6">
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-force-logout" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Logout Paksa User</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tindakan ini akan memaksa user keluar</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">User: <span id="logout-user-name" class="font-bold"></span></p>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alasan (opsional):</label>
                    <textarea id="logout-reason" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500" placeholder="Aktivitas mencurigakan, pelanggaran, dll..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button onclick="closeForceLogoutModal()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                        Batal
                    </button>
                    <button onclick="confirmForceLogout()" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">
                        Ya, Logout Paksa
                    </button>
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

        .activity-item {
            transition: all 0.2s;
        }

        .activity-item:hover {
            background: rgba(16, 185, 129, 0.05);
            transform: translateX(4px);
        }

        .detail-tab-btn {
            background: transparent;
            color: #6b7280;
            transition: all 0.3s;
        }
        
        .detail-tab-btn.active {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .detail-tab-btn:hover:not(.active) {
            background: #f3f4f6;
        }

        .dark .detail-tab-btn:hover:not(.active) {
            background: #374151;
        }
    </style>

    <script>
        let updateInterval;
        let currentPage = 1;
        let selectedUserId = null;
        let selectedSessionId = null;
        const currentAuthId = {{ auth()->id() }};

        document.addEventListener('DOMContentLoaded', function() {
            loadOnlineUsers();
            startAutoUpdate();
            setInterval(updateUserActivity, 120000);
            
            const filterRole = document.getElementById('filter-role');
            if (filterRole) {
                filterRole.addEventListener('change', () => loadHistory(1));
            }
        });

        function switchTab(tab) {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            
            document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
            document.getElementById('content-' + tab).classList.remove('hidden');
            
            if (tab === 'online') {
                loadOnlineUsers();
                startAutoUpdate();
            } else if (tab === 'history') {
                stopAutoUpdate();
                loadHistory();
            }
        }

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
                .catch(error => console.error('Error:', error));
        }

        function renderOnlineUsers(users) {
            const tbody = document.getElementById('online-users-table');
            
            if (!users || users.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
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
                const isAdmin = user.role === 'admin';
                const isCurrentUser = user.id === currentAuthId;
                
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
                                ${user.role_badge}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300">
                                ${user.current_page}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-mono text-sm">${user.ip_address}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">${user.browser} (${user.device})</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            <div class="text-sm">${user.login_at}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${user.login_at_readable}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                            <div class="text-sm">${user.last_activity}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${user.last_activity_readable}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-semibold">${user.duration}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button onclick="showUserDetail(${user.id})" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition-all">
                                    Detail
                                </button>
                                ${!isCurrentUser ? `
                                <button onclick="showForceLogoutModal(${user.session_id}, '${name.replace(/'/g, "\\'")}')" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-semibold transition-all">
                                    Logout
                                </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function showUserDetail(userId) {
            selectedUserId = userId;
            const modal = document.getElementById('modal-user-detail');
            modal.classList.remove('hidden');
            
            document.getElementById('modal-content').innerHTML = `
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-500"></div>
                </div>
            `;
            
            fetch(`/admin/monitoring/api/user-detail/${userId}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        renderUserDetail(result.data);
                    } else {
                        document.getElementById('modal-content').innerHTML = `
                            <div class="text-center py-12">
                                <p class="text-red-600 dark:text-red-400">${result.message}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('modal-content').innerHTML = `
                        <div class="text-center py-12">
                            <p class="text-red-600 dark:text-red-400">Gagal memuat data</p>
                        </div>
                    `;
                });
        }

        function renderUserDetail(data) {
            document.getElementById('modal-user-name').textContent = data.user.name;
            
            const currentSession = data.current_session;
            const sessionsHistory = data.sessions_history;
            const activities = data.activities;
            const stats = data.stats;
            
            let content = `
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl p-4">
                        <div class="text-2xl font-black text-blue-600 dark:text-blue-400">${stats.total_sessions}</div>
                        <div class="text-xs font-semibold text-blue-700 dark:text-blue-300">Total Sesi</div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-xl p-4">
                        <div class="text-2xl font-black text-purple-600 dark:text-purple-400">${stats.total_activities}</div>
                        <div class="text-xs font-semibold text-purple-700 dark:text-purple-300">Total Aktivitas</div>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-xl p-4">
                        <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">${stats.total_page_visits}</div>
                        <div class="text-xs font-semibold text-emerald-700 dark:text-emerald-300">Halaman Dikunjungi</div>
                    </div>
                </div>

                ${currentSession ? `
                <div class="bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-2 border-emerald-200 dark:border-emerald-700 rounded-2xl p-5 mb-6">
                    <h4 class="text-sm font-bold text-emerald-700 dark:text-emerald-300 mb-3 flex items-center gap-2">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        Sesi Saat Ini (Online)
                    </h4>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">IP Address:</span>
                            <span class="font-mono font-bold text-gray-900 dark:text-white ml-2">${currentSession.ip_address}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Browser:</span>
                            <span class="font-semibold text-gray-900 dark:text-white ml-2">${currentSession.browser}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Device:</span>
                            <span class="font-semibold text-gray-900 dark:text-white ml-2">${currentSession.device}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Halaman:</span>
                            <span class="font-semibold text-gray-900 dark:text-white ml-2">${currentSession.current_page}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Login:</span>
                            <span class="font-semibold text-gray-900 dark:text-white ml-2">${currentSession.login_at}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Aktivitas:</span>
                            <span class="font-semibold text-gray-900 dark:text-white ml-2">${currentSession.last_activity}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-gray-600 dark:text-gray-400">Durasi:</span>
                            <span class="font-bold text-emerald-600 dark:text-emerald-400 ml-2">${currentSession.duration}</span>
                        </div>
                    </div>
                </div>
                ` : `
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5 mb-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">User sedang offline</p>
                </div>
                `}

                <div class="flex gap-2 mb-4">
                    <button onclick="switchDetailTab('activities')" id="detail-tab-activities" class="detail-tab-btn active px-4 py-2 rounded-lg font-semibold text-sm">
                        Aktivitas Terakhir
                    </button>
                    <button onclick="switchDetailTab('sessions')" id="detail-tab-sessions" class="detail-tab-btn px-4 py-2 rounded-lg font-semibold text-sm">
                        Riwayat Sesi
                    </button>
                </div>

                <div id="detail-content-activities" class="detail-tab-content">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-4 max-h-96 overflow-y-auto">
                        ${activities.length > 0 ? activities.map(act => `
                            <div class="activity-item flex items-start gap-3 p-3 rounded-lg mb-2 border-l-4 ${act.type === 'login' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : act.type === 'logout' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-blue-500 bg-blue-50 dark:bg-blue-900/20'}">
                                <div class="text-2xl">${act.icon}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-bold ${act.color_class}">${act.type}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">${act.time_readable}</span>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">${act.page_name}</div>
                                    ${act.description !== '-' ? `<div class="text-xs text-gray-600 dark:text-gray-400 mt-1">${act.description}</div>` : ''}
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">${act.time}</div>
                                </div>
                            </div>
                        `).join('') : '<p class="text-center text-gray-500 dark:text-gray-400 py-8">Belum ada aktivitas</p>'}
                    </div>
                </div>

                <div id="detail-content-sessions" class="detail-tab-content hidden">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-4 max-h-96 overflow-y-auto">
                        ${sessionsHistory.length > 0 ? sessionsHistory.map(session => `
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 mb-3 border border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold ${session.status === 'online' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300'}">
                                        ${session.status === 'online' ? '🟢 Online' : '⚫ Offline'}
                                    </span>
                                    <span class="text-xs font-mono text-gray-500 dark:text-gray-400">${session.ip_address}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Login:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white ml-1">${session.login_at}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Logout:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white ml-1">${session.logout_at}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Browser:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white ml-1">${session.browser}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Durasi:</span>
                                        <span class="font-semibold text-emerald-600 dark:text-emerald-400 ml-1">${session.duration}</span>
                                    </div>
                                </div>
                            </div>
                        `).join('') : '<p class="text-center text-gray-500 dark:text-gray-400 py-8">Belum ada riwayat sesi</p>'}
                    </div>
                </div>
            `;
            
            document.getElementById('modal-content').innerHTML = content;
        }

        function switchDetailTab(tab) {
            document.querySelectorAll('.detail-tab-btn').forEach(btn => btn.classList.remove('active'));
            document.getElementById('detail-tab-' + tab).classList.add('active');
            
            document.querySelectorAll('.detail-tab-content').forEach(content => content.classList.add('hidden'));
            document.getElementById('detail-content-' + tab).classList.remove('hidden');
        }

        function closeUserDetailModal() {
            document.getElementById('modal-user-detail').classList.add('hidden');
            selectedUserId = null;
        }

        function showForceLogoutModal(sessionId, userName) {
            selectedSessionId = sessionId;
            document.getElementById('logout-user-name').textContent = userName;
            document.getElementById('logout-reason').value = '';
            document.getElementById('modal-force-logout').classList.remove('hidden');
        }

        function closeForceLogoutModal() {
            document.getElementById('modal-force-logout').classList.add('hidden');
            selectedSessionId = null;
        }

        function confirmForceLogout() {
            if (!selectedSessionId) return;
            
            const reason = document.getElementById('logout-reason').value;
            
            fetch('/admin/monitoring/api/force-logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    session_id: selectedSessionId,
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('✅ User berhasil di-logout paksa!');
                    closeForceLogoutModal();
                    loadOnlineUsers();
                } else {
                    alert('❌ ' + result.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Gagal logout paksa user');
            });
        }

        function loadHistory(page = 1) {
            const role = document.getElementById('filter-role').value;
            const tbody = document.getElementById('history-table');
            
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="px-6 py-16 text-center">
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
                        showError('Gagal memuat riwayat: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Gagal memuat riwayat login');
                });
        }

        function renderHistory(history) {
            const tbody = document.getElementById('history-table');
            
            if (!history || history.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
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
            
            tbody.innerHTML = history.map(item => `
                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300">
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">${item.user_name}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ${item.role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300'}">
                            ${item.role_badge}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-mono text-sm">${item.ip_address}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">${item.browser}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 text-sm">${item.login_at}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 text-sm">${item.logout_at}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-semibold">${item.duration}</td>
                    <td class="px-6 py-4">
                        <span class="status-badge ${item.status === 'online' ? 'status-online' : 'status-offline'}">
                            ${item.status_badge}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button onclick="showUserDetail(${item.user_id})" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition-all">
                            Detail
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function renderPagination(pagination) {
            const container = document.getElementById('pagination');
            if (!container || !pagination || pagination.last_page <= 1) {
                if (container) container.innerHTML = '';
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
                    <div class="flex gap-2">${pages}</div>
                </div>
            `;
        }

        function updateStats(stats) {
            document.getElementById('stat-online').textContent = stats.total_online || 0;
            document.getElementById('stat-guru').textContent = stats.total_guru || 0;
            document.getElementById('stat-total').textContent = stats.total_users || 0;
        }

        function updateTimestamp(timestamp) {
            const el = document.getElementById('last-update');
            if (el) el.textContent = timestamp || '';
        }

        function updateUserActivity() {
            fetch('/admin/monitoring/api/update-activity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(error => console.error('Error:', error));
        }

        function startAutoUpdate() {
            stopAutoUpdate();
            updateInterval = setInterval(loadOnlineUsers, 5000);
        }

        function stopAutoUpdate() {
            if (updateInterval) clearInterval(updateInterval);
        }

        function showError(message) {
            const tbody = document.getElementById('history-table');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
                            <div class="text-red-600 dark:text-red-400 font-semibold">${message}</div>
                        </td>
                    </tr>
                `;
            }
        }

        window.addEventListener('beforeunload', stopAutoUpdate);
    </script>
</x-app-layout>