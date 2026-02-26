<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-active { 
            background: linear-gradient(to right, #2563eb, #3b82f6); 
            color: white !important; 
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        aside::-webkit-scrollbar { width: 4px; }
        aside::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900" x-data="{ sidebarOpen: false }"> <div class="flex min-h-screen">
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="w-[280px] bg-[#0f172a] text-slate-400 flex-shrink-0 fixed h-full z-[30] shadow-2xl flex flex-col overflow-hidden transition-transform duration-300 lg:translate-x-0">
            
            <div class="p-8 mb-2 flex-shrink-0 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1.5 rounded-xl shadow-sm shrink-0">
                        <img src="{{ asset('images/kominfo.png') }}" alt="Logo" class="h-8 w-auto">
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="border-b-[1.5px] border-white/20 pb-0.5 mb-0.5 pr-2">
                            <h1 class="text-base md:text-lg font-[900] italic tracking-tighter leading-tight">
                                <span class="text-white">Diskom</span><span class="text-[#f59e0b]">infotik</span>
                            </h1>
                        </div>
                        <p class="text-[8px] font-bold text-blue-400 tracking-[0.2em] leading-none uppercase">Indragiri Hulu</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white text-2xl">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <nav class="px-6 space-y-1 flex-1 overflow-y-auto custom-scrollbar">
                <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/dashboard') ? 'sidebar-active' : '' }}">
                    <i class="bi bi-grid-1x2-fill text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <div x-data="{ open: {{ Request::is('admin/data-tamu*') ? 'true' : 'false' }} }"> 
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-people-fill text-lg"></i>
                            <span>Data Tamu</span>
                        </div>
                        <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="mt-2 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.data-tamu.hari-ini') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white {{ Request::is('admin/data-tamu-hari-ini') ? 'text-blue-400 font-bold' : '' }}">Hari Ini</a>
                        <a href="{{ route('admin.data-tamu') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white {{ Request::is('admin/data-tamu') && !Request::is('admin/data-tamu-hari-ini') ? 'text-blue-400 font-bold' : '' }}">Total Tamu</a>
                    </div>
                </div>

                

                <a href="{{ route('admin.data-pegawai') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-person-badge-fill text-lg"></i>
                    <span>Data Pegawai</span>
                </a>

                <a href="{{ route('admin.jadwal-pimpinan') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/jadwal-pimpinan*') ? 'sidebar-active' : '' }}">
                    <i class="bi bi-calendar2-check-fill text-lg"></i>
                    <span>Jadwal Pimpinan</span>
                </a>

                @if(Auth::guard('admin')->user()->role == 'superadmin')
                <div class="pt-4 mt-4 border-t border-slate-800">
                    <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Administrator</p>
                    <a href="{{ route('admin.manajemen-user') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/manajemen-user*') ? 'sidebar-active' : '' }}">
                        <i class="bi bi-person-gear text-lg"></i>
                        <span>Manajemen User</span>
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition opacity-ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition opacity-ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 z-[25] lg:hidden" x-cloak></div>

        <main class="flex-1 ml-0 lg:ml-[280px] p-4 md:p-10 transition-all duration-300">
            <header class="bg-white p-4 md:p-6 rounded-[1.5rem] md:rounded-[2rem] shadow-sm border border-slate-100 mb-6 md:mb-10 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <div>
                        <h2 class="text-lg md:text-xl font-extrabold text-slate-800 tracking-tight">Statistik Kunjungan</h2>
                        <p class="text-[10px] md:text-[11px] text-slate-500 mt-0.5">Monitoring data secara real-time</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 md:gap-4">
                    <div class="hidden lg:flex bg-slate-50 border border-slate-100 px-5 py-2.5 rounded-xl text-[12px] font-bold text-slate-600 items-center">         
                        <i class="bi bi-calendar3 mr-3 text-blue-600"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </div>

                    <div class="relative" x-data="{ openNotify: false }">
                        <button @click="openNotify = !openNotify; clearNotification()" 
                            class="relative w-10 h-10 md:w-11 md:h-11 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all border border-slate-100">
                            <i class="bi bi-bell-fill text-lg"></i>
                            <span id="notif-badge" class="absolute top-2 right-2 w-4 h-4 flex items-center justify-center text-[10px] font-bold text-white bg-rose-500 rounded-full hidden">0</span>
                        </button>

                        <div x-show="openNotify" x-transition x-cloak @click.outside="openNotify = false" 
                             class="absolute right-0 mt-3 w-72 md:w-80 bg-white border border-slate-100 rounded-3xl shadow-2xl z-50 p-4 md:p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-xs font-extrabold text-slate-400 uppercase tracking-widest">Tamu Baru</h4>
                                <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded-lg font-bold">Hari Ini</span>
                            </div>
                            <div id="notif-list" class="space-y-3 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                <p class="text-center text-slate-400 text-xs py-8 italic">Menunggu tamu baru...</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-[1px] h-8 bg-slate-100 hidden sm:block"></div>

                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" class="flex items-center gap-3 p-1 rounded-2xl hover:bg-slate-50 transition-all group">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-200">
                                {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-xs font-bold text-slate-800 leading-none mb-1">{{ Auth::guard('admin')->user()->name }}</p>
                                <p class="text-[9px] text-blue-500 font-bold uppercase tracking-tighter">{{ Auth::guard('admin')->user()->role }}</p>
                            </div>
                            <i class="bi bi-chevron-down text-[10px] text-slate-400" :class="openProfile ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="openProfile" x-transition x-cloak @click.outside="openProfile = false" 
                             class="absolute top-full right-0 mt-2 w-48 bg-white border border-slate-100 rounded-2xl shadow-2xl p-2 z-50">
                            <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-[12px] font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                <i class="bi bi-shield-lock"></i>
                                <span>Ubah Password</span>
                            </a>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-[12px] font-bold text-red-500 hover:bg-red-50 transition-all text-left">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 mb-8">
                @php
                    $cards = [
                        ['title' => 'Tamu Hari Ini', 'value' => $tamuHariIni, 'stats' => $statsHariIni, 'color' => 'blue', 'icon' => 'bi-person-check'],
                        ['title' => date('F Y'), 'value' => $tamuBulanIni, 'stats' => $statsBulanIni, 'color' => 'cyan', 'icon' => 'bi-calendar-event'],
                        ['title' => 'Total Tamu', 'value' => $totalTamu, 'stats' => $statsTotal, 'color' => 'indigo', 'icon' => 'bi-database']
                    ];
                @endphp

                @foreach($cards as $card)
                <div class="bg-white p-5 md:p-7 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-6 md:mb-8">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600 rounded-2xl flex items-center justify-center text-xl shadow-sm">
                                <i class="bi {{ $card['icon'] }}"></i>
                            </div>
                            <div>
                                <span class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em] leading-none">{{ $card['title'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <h3 class="text-3xl md:text-5xl font-black text-slate-800 tracking-tighter">{{ $card['value'] }}</h3>
                        </div>
                    </div>

                    <div class="pt-4 mt-1 border-t border-slate-50"> 
                        <div class="grid grid-cols-3 gap-2 mb-2">
                            <div class="bg-slate-50/50 rounded-xl p-2 text-center">
                                <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase mb-0.5">PNS</p>
                                <p class="text-xs font-bold text-slate-700 leading-none">{{ $card['stats']->pns ?? 0 }}</p>
                            </div>
                            <div class="bg-slate-50/50 rounded-xl p-2 text-center">
                                <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase mb-0.5">Swasta</p>
                                <p class="text-xs font-bold text-slate-700 leading-none">{{ $card['stats']->swasta ?? 0 }}</p>
                            </div>
                            <div class="bg-slate-50/50 rounded-xl p-2 text-center">
                                <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase mb-0.5">Pers</p>
                                <p class="text-xs font-bold text-slate-700 leading-none">{{ $card['stats']->wartawan ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-slate-50/50 rounded-xl p-2 text-center">
                                <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase mb-0.5">Wirausaha</p>
                                <p class="text-xs font-bold text-slate-700 leading-none">{{ $card['stats']->wirausaha ?? 0 }}</p>
                            </div>
                            <div class="bg-slate-50/50 rounded-xl p-2 text-center">
                                <p class="text-[7px] md:text-[8px] font-bold text-slate-400 uppercase mb-0.5">Pelajar</p>
                                <p class="text-xs font-bold text-slate-700 leading-none">{{ $card['stats']->pelajar ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-all">
                    <div class="flex items-center gap-4 md:gap-6">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-emerald-50 text-emerald-600 rounded-2xl md:rounded-3xl flex items-center justify-center text-xl md:text-2xl shadow-sm group-hover:scale-110 transition-transform">
                            <i class="bi bi-envelope-check-fill"></i>
                        </div>
                        <div>
                            <p class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Surat Masuk</p>
                            <h3 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tighter">{{ $totalSuratMasuk ?? 0 }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('admin.surat-masuk') }}" class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-emerald-600 hover:text-white transition-all">
                        <i class="bi bi-arrow-right-short text-2xl"></i>
                    </a>
                </div>

                <div class="bg-white p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center justify-between group hover:border-orange-200 transition-all">
                    <div class="flex items-center gap-4 md:gap-6">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-orange-50 text-orange-600 rounded-2xl md:rounded-3xl flex items-center justify-center text-xl md:text-2xl shadow-sm group-hover:scale-110 transition-transform">
                            <i class="bi bi-send-check-fill"></i>
                        </div>
                        <div>
                            <p class="text-[10px] md:text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Surat Keluar</p>
                            <h3 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tighter">{{ $totalSuratKeluar ?? 0 }}</h3>
                        </div>
                    </div>
                    <a href="{{ route('admin.surat-keluar') }}" class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-orange-600 hover:text-white transition-all">
                        <i class="bi bi-arrow-right-short text-2xl"></i>
                    </a>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-[#0f172a] p-6 md:p-8 rounded-[2rem] md:rounded-[2.5rem] text-white shadow-xl flex flex-col md:flex-row justify-between items-center border border-white/5 relative overflow-hidden gap-4">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    <div class="flex items-center gap-4 md:gap-6 relative z-10">
                        <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-500/20 rounded-2xl flex items-center justify-center text-blue-400 text-2xl border border-blue-500/30">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="text-center md:text-left">
                            <h4 class="text-base md:text-lg font-bold">Sistem Informasi Diskominfo</h4>
                            <p class="text-slate-400 text-xs md:text-sm">Monitoring Tamu & Manajemen Arsip Terintegrasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentLatestIdFromDB = 0;

        function checkNewGuest() {
            fetch("{{ route('admin.cek-tamu') }}")
                .then(response => response.json())
                .then(res => {
                    if (res.jumlah > 0) {
                        currentLatestIdFromDB = res.latest_id;
                        const lastSeenId = localStorage.getItem('admin_last_seen_id') || 0;

                        if (currentLatestIdFromDB > lastSeenId) {
                            const badge = document.getElementById('notif-badge');
                            const newItemsCount = res.data.filter(t => t.id > lastSeenId).length;
                            if(newItemsCount > 0) {
                                badge.innerText = newItemsCount;
                                badge.classList.remove('hidden');
                            }
                        }

                        const list = document.getElementById('notif-list');
                        let items = '';
                        res.data.forEach(t => {
                            items += `
                                <div class="flex items-center gap-4 p-3 hover:bg-slate-50 rounded-2xl transition-all border border-transparent hover:border-slate-100">
                                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center font-bold text-sm uppercase shrink-0">
                                        ${t.nama.substring(0, 1)}
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-xs font-bold text-slate-800 truncate">${t.nama}</p>
                                        <p class="text-[10px] text-slate-400 truncate">${t.keperluan}</p>
                                    </div>
                                </div>`;
                        });
                        list.innerHTML = items;
                    }
                })
                .catch(error => console.log('Belum ada tamu baru'));
        }

        function clearNotification() {
            if (currentLatestIdFromDB > 0) {
                localStorage.setItem('admin_last_seen_id', currentLatestIdFromDB);
            }
            const badge = document.getElementById('notif-badge');
            badge.classList.add('hidden');
        }

        setInterval(checkNewGuest, 30000);
        checkNewGuest();
    </script>
</body>
</html>