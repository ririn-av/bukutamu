<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Tamu - Diskominfo</title>
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
<body class="bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">
        <aside class="w-[280px] bg-[#0f172a] text-slate-400 flex-shrink-0 fixed h-full z-20 shadow-2xl flex flex-col overflow-hidden">
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

            <nav class="px-6 space-y-1 flex-1 overflow-y-auto custom-scrollbar" x-data="{ openTamu: true, openSurat: false }">
                <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-grid-1x2-fill text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <div> 
                    <button @click="openTamu = !openTamu" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white sidebar-active">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-people-fill text-lg"></i>
                            <span>Data Tamu</span>
                        </div>
                        <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="openTamu ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openTamu" x-transition x-cloak class="mt-2 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.data-tamu.hari-ini') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:text-white">Hari Ini</a>
                       <a href="{{ route('admin.data-tamu') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:bg-slate-800 hover:text-white transition-all">Total Tamu</a>
                    </div>
                </div>

              <div x-data="{ open: {{ Request::is('admin/surat*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/surat*') ? 'text-white bg-slate-800/50' : '' }}">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-envelope-paper-fill text-lg"></i>
                            <span>Arsip Surat</span>
                        </div>
                        <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition x-cloak class="mt-2 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.surat-masuk') }}" class="block px-4 py-2 text-[13px] rounded-lg {{ Request::is('admin/surat-masuk') ? 'text-blue-400 font-bold' : 'hover:text-white' }}">Surat Masuk</a>
                        <a href="{{ route('admin.surat-keluar') }}" class="block px-4 py-2 text-[13px] rounded-lg {{ Request::is('admin/surat-keluar') ? 'text-blue-400 font-bold' : 'hover:text-white' }}">Surat Keluar</a>
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

        <main class="flex-1 ml-[280px] p-10">
            <header class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-10 flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Edit Informasi Tamu</h2>
                    <p class="text-[11px] text-slate-500 mt-0.5">Lakukan pembaharuan data tamu terpilih</p>
                </div>
                
                <div class="flex items-center gap-4">
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

            <div class="max-w-4xl mx-auto">
                <form id="formEditTamu" action="{{ route('admin.update', $tamu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-[#0f172a] p-8 flex items-center gap-8 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl"></div>
                            <div class="relative z-10">
                                <img src="{{ asset('fototamu/' . $tamu->foto) }}" 
                                     class="w-24 h-24 object-cover rounded-3xl border-4 border-white/10 shadow-2xl">
                            </div>
                            <div class="text-white relative z-10">
                                <span class="text-[10px] font-black uppercase tracking-widest bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full border border-blue-500/20">Profil Tamu</span>
                                <h3 class="text-2xl font-bold mt-2">{{ $tamu->nama }}</h3>
                            </div>
                        </div>

                        <div class="p-10 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $tamu->nama) }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 outline-none" required>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Pekerjaan</label>
                                    <select name="pekerjaan" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 outline-none appearance-none" required>
                                        <option value="ASN" {{ old('pekerjaan', $tamu->pekerjaan) == 'ASN' ? 'selected' : '' }}>PNS / ASN</option>
                                        <option value="Swasta" {{ old('pekerjaan', $tamu->pekerjaan) == 'Swasta' ? 'selected' : '' }}>Pegawai Swasta</option>
                                        <option value="Wartawan" {{ old('pekerjaan', $tamu->pekerjaan) == 'Wartawan' ? 'selected' : '' }}>Wartawan</option>
                                        <option value="Wirausaha" {{ old('pekerjaan', $tamu->pekerjaan) == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                        <option value="Mahasiswa/Pelajar" {{ old('pekerjaan', $tamu->pekerjaan) == 'Mahasiswa/Pelajar' ? 'selected' : '' }}>Mahasiswa / Pelajar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Instansi / Asal</label>
                                    <input type="text" name="instansi_asal" value="{{ old('instansi_asal', $tamu->instansi_asal) }}" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 outline-none" required>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Bidang Tujuan</label>
                                    <select name="bidang_tujuan" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 outline-none appearance-none" required>
                                        <option value="Sekretariat" {{ old('bidang_tujuan', $tamu->bidang_tujuan) == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                                        <option value="Bidang IKP" {{ old('bidang_tujuan', $tamu->bidang_tujuan) == 'Bidang IKP' ? 'selected' : '' }}>Bidang IKP (Informasi & Komunikasi Publik)</option>
                                        <option value="Bidang e-Gov" {{ old('bidang_tujuan', $tamu->bidang_tujuan) == 'Bidang e-Gov' ? 'selected' : '' }}>Bidang Layanan e-Government</option>
                                        <option value="Bidang Statistik" {{ old('bidang_tujuan', $tamu->bidang_tujuan) == 'Bidang Statistik' ? 'selected' : '' }}>Bidang Statistik</option>
                                        <option value="Kepala Dinas" {{ old('bidang_tujuan', $tamu->bidang_tujuan) == 'Kepala Dinas' ? 'selected' : '' }}>Kepala Dinas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Keperluan Kunjungan</label>
                                <textarea name="keperluan" rows="4" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-700 outline-none resize-none" required>{{ old('keperluan', $tamu->keperluan) }}</textarea>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-10 py-8 flex justify-between items-center border-t border-slate-100">
                            <a href="{{ route('admin.data-tamu') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-all uppercase tracking-widest">Batal</a>
                            <button type="button" onclick="konfirmasiSimpan()" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3.5 rounded-2xl font-bold transition-all shadow-lg shadow-blue-600/20 active:scale-95 flex items-center gap-3">
                                <i class="bi bi-cloud-arrow-up-fill text-lg"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function konfirmasiSimpan() {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Pastikan data tamu sudah diperiksa kembali.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Kembali',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formEditTamu').submit();
                }
            })
        }
    </script>
</body>
</html>