<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai - Diskominfo</title>
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
<body class="bg-slate-50 text-slate-900" x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    editData: { id: '', nama: '', nip: '', jabatan: '' } 
}">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="w-[280px] bg-[#0f172a] text-slate-400 flex-shrink-0 fixed h-full z-20 shadow-2xl flex flex-col overflow-hidden">
            <div class="p-8 mb-2 flex-shrink-0">
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

                

                <a href="{{ route('admin.data-pegawai') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/data-pegawai*') ? 'sidebar-active' : '' }}">
                    <i class="bi bi-person-badge-fill text-lg"></i>
                    <span>Data Pegawai</span>
                </a>

                <a href="{{ route('admin.jadwal-pimpinan') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/jadwal-pimpinan*') ? 'sidebar-active' : '' }}">
                    <i class="bi bi-calendar2-check-fill text-lg"></i>
                    <span>Jadwal Pimpinan</span>
                </a>

                {{-- Bagian yang diperbaiki (Menambahkan @endif) --}}
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
        
        <main class="flex-1 ml-[280px] p-10">
            <header class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-10 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Database Pegawai</h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Total: <span class="text-blue-600 font-bold">{{ count($pegawai) }}</span> orang terdaftar</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <button @click="showAddModal = true" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-[12px] shadow-lg shadow-blue-200 flex items-center gap-2 hover:bg-blue-700 transition-all active:scale-95">
                        <i class="bi bi-person-plus-fill text-base"></i> Tambah Pegawai
                    </button>
                    
                    <div class="w-[1px] h-8 bg-slate-100 mx-2"></div>

                     <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" class="flex items-center gap-3 p-1.5 rounded-2xl hover:bg-slate-50 transition-all group">
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

            {{-- TABEL --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Nama Pegawai</th>
                                <th class="px-8 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Jabatan</th>
                                <th class="px-8 py-6 text-[11px] font-extrabold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
    @foreach($pegawai as $p)
    <tr class="hover:bg-slate-50/50 transition-all group">
        <td class="px-8 py-5">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all">
                    {{ strtoupper(substr($p->nama, 0, 1)) }}
                </div>
                <div>
                    <p class="font-bold text-slate-800 text-sm">{{ $p->nama }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">NIP: {{ $p->nip ?? '-' }}</p>
                </div>
            </div>
        </td>
        <td class="px-8 py-5">
            <span class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-bold uppercase tracking-tighter">
                {{ $p->jabatan }}
            </span>
        </td>
        <td class="px-8 py-5">
            <div class="flex items-center justify-center gap-2">
                {{-- TOMBOL EDIT --}}
                <button @click="editData = { id: '{{ $p->id }}', nama: '{{ $p->nama }}', nip: '{{ $p->nip }}', jabatan: '{{ $p->jabatan }}' }; showEditModal = true" 
                    class="w-9 h-9 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center shadow-sm">
                    <i class="bi bi-pencil-square"></i>
                </button>

                {{-- TOMBOL HAPUS --}}
                <form action="{{ route('admin.data-pegawai.hapus', $p->id) }}" method="POST" onsubmit="return confirm('Hapus data pegawai ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-9 h-9 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all inline-flex items-center justify-center shadow-sm">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL --}}
    <div x-show="showAddModal" x-transition x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-bg">
        <div @click.outside="showAddModal = false" class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl relative">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Tambah Pegawai</h3>
                    <p class="text-[11px] text-slate-400 mt-1 uppercase font-bold tracking-widest">Input Data Master</p>
                </div>
                <button @click="showAddModal = false" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.data-pegawai.simpan') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-2 block">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Isi Nama...." class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                </div>

                <div>
                    <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-2 block">NIP (Opsional)</label>
                    <input type="text" name="nip" placeholder="NIP..." class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-2 block">Jabatan</label>
                    <input type="text" name="jabatan" placeholder="Isi Jabatan.." class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="showAddModal = false" class="flex-1 bg-slate-50 text-slate-500 py-4 rounded-2xl font-bold text-sm hover:bg-slate-100 transition-all">Batal</button>
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold text-sm shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>


    {{-- MODAL EDIT --}}
<div x-show="showEditModal" x-transition x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-bg">
    <div @click.outside="showEditModal = false" class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl relative">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Edit Data Pegawai</h3>
                <p class="text-[11px] text-slate-400 mt-1 uppercase font-bold tracking-widest">Perbarui Data Master</p>
            </div>
            <button @click="showEditModal = false" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-rose-50 hover:text-rose-500 transition-all">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form :action="'{{ url('admin/data-pegawai/update') }}/' + editData.id" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-2 block">Nama Lengkap</label>
                <input type="text" name="nama" x-model="editData.nama" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
            </div>

            <div>
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-2 block">NIP </label>
                <input type="text" name="nip" x-model="editData.nip" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>

            <div>
                <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-2 block">Jabatan</label>
                <input type="text" name="jabatan" x-model="editData.jabatan" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" @click="showEditModal = false" class="flex-1 bg-slate-50 text-slate-500 py-4 rounded-2xl font-bold text-sm hover:bg-slate-100 transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-amber-500 text-white py-4 rounded-2xl font-bold text-sm shadow-lg shadow-amber-200 hover:bg-amber-600 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>