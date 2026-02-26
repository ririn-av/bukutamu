<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Jadwal - Dashboard Admin</title>
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
        .modal-bg { backdrop-filter: blur(8px); background-color: rgba(15, 23, 42, 0.5); }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        @media print {
            aside, .btn-no-print, header, .action-cell { display: none !important; }
            main { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
     <aside class="w-[280px] bg-[#0f172a] text-slate-400 flex-shrink-0 fixed h-full z-20 shadow-2xl flex flex-col overflow-hidden btn-no-print">
            <div class="p-8 mb-2 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1.5 rounded-xl shadow-sm shrink-0">
                        <img src="{{ asset('images/kominfo.png') }}" alt="Logo" class="h-8 w-auto">
                    </div>
                    <div class="flex flex-col justify-center">
                        <div class="border-b-[1.5px] border-white/20 pb-0.5 mb-0.5 pr-2">
                            <h1 class="text-base md:text-lg font-[900] italic tracking-tighter leading-tight">
                                <span class="text-white">Diskom</span><span class="text-[#f59e0b]">info</span>
                            </h1>
                        </div>
                        <p class="text-[8px] font-bold text-blue-400 tracking-[0.2em] leading-none uppercase">Indragiri Hulu</p>
                    </div>
                </div>
            </div>

            <nav class="px-6 space-y-1 flex-1 overflow-y-auto custom-scrollbar">
                <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-grid-1x2-fill text-lg"></i>
                    <span>Dashboard</span>
                </a>

                {{-- Dropdown Data Tamu --}}
                <div x-data="{ open: {{ Request::is('admin/data-tamu*') ? 'true' : 'false' }} }"> 
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-people-fill text-lg"></i>
                            <span>Data Tamu</span>
                        </div>
                        <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="mt-2 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.data-tamu.hari-ini') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white">Hari Ini</a>
                        <a href="{{ route('admin.data-tamu') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white">Total Tamu</a>
                    </div>
                </div>

                {{-- Dropdown Arsip Surat --}}
                <div x-data="{ open: {{ Request::is('admin/surat*') || Request::is('admin/arsip*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-envelope-paper-fill text-lg"></i>
                            <span>Arsip Surat</span>
                        </div>
                        <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="mt-2 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.surat-masuk') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white">Surat Masuk</a>
                        <a href="{{ route('admin.surat-keluar') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white">Surat Keluar</a>
                    </div>
                </div>

                <a href="{{ route('admin.data-pegawai') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-person-badge-fill text-lg"></i>
                    <span>Data Pegawai</span>
                </a>

                <a href="{{ route('admin.jadwal-pimpinan') }}" class="sidebar-active flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300">
                    <i class="bi bi-calendar2-check-fill text-lg"></i>
                    <span>Jadwal Pimpinan</span>
                </a>

                

                

                @if(Auth::guard('admin')->user()->role == 'superadmin')
                <div class="pt-4 mt-4 border-t border-slate-800">
                    <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Administrator</p>
                    <a href="{{ route('admin.manajemen-user') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                        <i class="bi bi-person-gear text-lg"></i>
                        <span>Manajemen User</span>
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 ml-[280px] p-10">
       {{-- HEADER HALAMAN --}}
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Riwayat Aktivitas</h2>
        <p class="text-sm text-slate-500 font-medium">Log perubahan status pimpinan secara mendetail</p>
    </div>
    <a href="{{ route('admin.jadwal-pimpinan') }}" class="w-fit bg-white hover:bg-slate-50 text-slate-700 px-6 py-3 rounded-2xl font-bold text-sm transition-all flex items-center gap-2 border border-slate-200 shadow-sm">
        <i class="bi bi-arrow-left"></i> Kembali ke Jadwal
    </a>
</header>

{{-- SECTION FILTER --}}
<div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-10 btn-no-print">
    <form action="{{ route('admin.jadwal-history') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
        {{-- Filter Nama Pejabat --}}
        <div class="space-y-2">
            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block ml-1">Cari Pejabat</label>
            <select name="pejabat" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                <option value="">Semua Pejabat</option>
                @foreach($daftar_pejabat as $p)
                    <option value="{{ $p->id }}" {{ request('pejabat') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Rentang Tanggal --}}
        <div class="space-y-2">
            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block ml-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>

        <div class="space-y-2">
            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest block ml-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
                <i class="bi bi-filter"></i> Filter
            </button>
            <a href="{{ route('admin.jadwal-history') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3 rounded-xl font-bold text-sm transition-all flex items-center justify-center">
                Reset
            </a>
        </div>
    </form>
</div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Pejabat</th>
                            <th class="px-6 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Status Log</th>
                            <th class="px-6 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Keterangan</th>
                            <th class="px-6 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Periode</th>
                            <th class="px-8 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest text-right">Waktu Update</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
    @forelse($histories as $log)
    <tr class="hover:bg-blue-50/30 transition-all duration-200 group">
        <td class="px-8 py-6">
            <p class="font-bold text-slate-800 text-sm mb-1">{{ $log->nama }}</p>
            <p class="text-[10px] font-bold text-blue-500 uppercase">{{ $log->jabatan }}</p>
        </td>
        <td class="px-6 py-6">
            @php
                // Logika penentuan warna berdasarkan teks status
                $statusText = strtoupper($log->status);
                // Warna Default (Abu-abu)
                $colorClass = 'text-slate-600 border-slate-200 bg-slate-50'; 

                if ($statusText == 'TERSEDIA') {
                    $colorClass = 'text-emerald-700 border-emerald-200 bg-emerald-50';
                } elseif ($statusText == 'RAPAT') {
                    $colorClass = 'text-amber-700 border-amber-200 bg-amber-50';
                } elseif (in_array($statusText, ['CUTI', 'IZIN', 'SAKIT'])) {
                    $colorClass = 'text-rose-700 border-rose-200 bg-rose-50';
                } elseif (in_array($statusText, ['DINAS LUAR', 'DL', 'PERJALANAN DINAS'])) {
                    $colorClass = 'text-blue-700 border-blue-200 bg-blue-50';
                }
            @endphp

            <span class="px-3 py-1.5 rounded-lg text-[10px] font-extrabold border {{ $colorClass }} uppercase tracking-wider transition-colors">
                {{ $log->status }}
            </span>
        </td>
        <td class="px-6 py-6 text-sm text-slate-600 italic">"{{ $log->info_utama ?? '-' }}"</td>
        <td class="px-6 py-6 text-[11px] font-bold text-slate-500">
            @if($log->mulai_tgl)
                <div class="flex items-center gap-1">
                    <i class="bi bi-calendar3 text-[10px]"></i>
                    {{ date('d/m/y', strtotime($log->mulai_tgl)) }} - {{ date('d/m/y', strtotime($log->sampai_tgl)) }}
                </div>
            @else 
                <span class="text-slate-300 italic">Harian</span>
            @endif
        </td>
        <td class="px-8 py-6 text-right">
            <p class="text-sm font-bold text-slate-800">{{ $log->created_at->format('d M Y') }}</p>
            <p class="text-[10px] text-slate-400 font-medium uppercase">{{ $log->created_at->format('H:i') }} WIB</p>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="px-8 py-16 text-center text-slate-400 italic">
            <i class="bi bi-inbox text-4xl block mb-4 opacity-20"></i>
            Belum ada riwayat tercatat.
        </td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>