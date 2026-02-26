<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tamu - Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
        /* CSS Tambahan untuk Cetak */
       /* CSS Perbaikan untuk Cetak */
@media print {
    /* 1. Paksa Browser memunculkan warna (Tailwind BG-Color) */
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    /* 2. Sembunyikan semua elemen navigasi & interaksi */
    aside, 
    header, 
    nav,
    button,
    form,
    .lg\:col-span-7, 
    .lg\:col-span-5,
    .relative,
    .flex.flex-col.md\:flex-row, /* Container filter & export */
    #photoModal {
        display: none !important;
    }

    /* 3. Reset Layout Utama */
    main {
        margin-left: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        min-height: auto !important;
    }

    body {
        background-color: white !important;
    }

    /* 4. Optimasi Tabel */
    #area-cetak {
        position: static !important; /* Ubah dari absolute agar tidak tumpang tindih */
        width: 100% !important;
        overflow: visible !important;
    }

    table {
        width: 100% !important;
        border: 1px solid #e2e8f0 !important;
        table-layout: auto !important;
    }

    th, td {
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 8px 12px !important;
        word-break: break-word !important;
    }

    /* Sembunyikan kolom "Aksi" & "Berkas" saat cetak karena tidak bisa diklik di kertas */
    th:last-child, td:last-child,
    th:nth-last-child(2), td:nth-last-child(2) {
        display: none !important;
    }

    /* 5. Paksa gambar tetap muncul kecil */
    img {
        max-width: 50px !important;
        height: auto !important;
        border-radius: 4px !important;
    }
}
            
        
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
                    <span class="text-white">Diskom</span><span class="text-[#f59e0b]">infotik</span>
                </h1>
            </div>
            <p class="text-[8px] font-bold text-blue-400 tracking-[0.2em] leading-none uppercase">
                Indragiri Hulu
            </p>
        </div>
    </div>
</div>

            <nav class="px-6 space-y-2 flex-1 overflow-y-auto">
                <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/dashboard') ? 'sidebar-active' : '' }}">
                    <i class="bi bi-grid-1x2-fill text-lg"></i>
                    <span>Dashboard</span>
                </a>

                
                    
                     <div x-data="{ open: true }"> 
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-people-fill text-lg text-white"></i>
                            <span class="text-white">Data Tamu</span>
                        </div>
                        <i class="bi bi-chevron-down text-[10px] transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" class="mt-2 ml-4 pl-4 border-l border-slate-700 space-y-1">
                        <a href="{{ route('admin.data-tamu.hari-ini') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:bg-slate-800 hover:text-white transition-all">Hari Ini</a>
                        <a href="{{ route('admin.data-tamu') }}" class="block px-4 py-2 text-[13px] font-bold text-white rounded-lg bg-slate-800/50">Total Tamu</a>
                    </div>
                </div>

                

                <a href="{{ route('admin.data-pegawai') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-person-badge-fill text-lg"></i>
                    <span>Data Pegawai</span>
                </a>

                 {{-- Menu Jadwal Pimpinan --}}
<a href="{{ route('admin.jadwal-pimpinan') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/jadwal-pimpinan*') ? 'sidebar-active' : '' }}">
    <i class="bi bi-calendar2-check-fill text-lg"></i>
    <span>Jadwal Pimpinan</span>
</a>

                @if(Auth::guard('admin')->user()->role == 'superadmin')
                <div class="pt-4 mt-4 border-t border-slate-800">
                    <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Administrator</p>
                    
                    <a href="{{ route('admin.manajemen-user') }}" 
                       class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/manajemen-user*') ? 'sidebar-active' : '' }}">
                        <i class="bi bi-person-gear text-lg"></i>
                        <span>Manajemen User</span>
                    </a>
                </div>
                @endif
            </nav>

           
        </aside>

   


   <main class="flex-1 ml-[280px] p-10 min-h-screen">
            
        <header class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 mb-10 flex justify-between items-center">
    <div>
        <nav class="flex text-[10px] text-slate-400 gap-2 mb-1 font-bold uppercase tracking-widest">
            <span>Admin</span>
            <i class="bi bi-chevron-right text-[8px]"></i>
            <span class="text-blue-600">Data Tamu</span>
        </nav>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight leading-none">Data Tamu Hari Ini</h2>
        <p class="text-[11px] text-slate-500 mt-1.5">Daftar kunjungan pada <span class="font-bold text-slate-700"> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span></p>
    </div>
    
    <div class="flex items-center gap-6">
        <div class="hidden md:flex items-center gap-4 bg-blue-50/50 border border-blue-100 px-5 py-2.5 rounded-2xl">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <i class="bi bi-people-fill text-lg"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest leading-none mb-1">Total Tamu</p>
                <p class="text-xl font-black text-slate-800 leading-none">{{ $tamu->count() }}</p>
            </div>
        </div>

        <div class="w-[1px] h-10 bg-slate-100 hidden md:block"></div>

        <div class="relative" x-data="{ openProfile: false }">
            <button @click="openProfile = !openProfile" class="flex items-center gap-3 p-1 rounded-2xl hover:bg-slate-50 transition-all group">
                <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                </div>
                <div class="text-left hidden sm:block">
                    <p class="text-xs font-bold text-slate-800 leading-none mb-1">{{ Auth::guard('admin')->user()->name }}</p>
                    <p class="text-[9px] text-blue-600 font-bold uppercase tracking-tighter">{{ Auth::guard('admin')->user()->role }}</p>
                </div>
                <i class="bi bi-chevron-down text-[10px] text-slate-400 transition-transform" :class="openProfile ? 'rotate-180' : ''"></i>
            </button>

            <div x-show="openProfile" 
                 @click.outside="openProfile = false" 
                 x-transition
                 class="absolute top-full right-0 mt-3 w-48 bg-white border border-slate-100 rounded-2xl shadow-2xl p-2 z-50"
                 style="display: none;">
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[12px] font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">
                    <i class="bi bi-shield-lock"></i>
                    <span>Ubah Password</span>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[12px] font-bold text-red-500 hover:bg-red-50 transition-all text-left">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

            <div class="p-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
                    <div class="lg:col-span-7 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-700 mb-6 flex items-center text-lg">
                            <i class="bi bi-graph-up-arrow text-indigo-500 me-3"></i>Kunjungan Per Hari
                        </h3>
                        <div class="h-72 w-full">
                            <canvas id="chartKedatangan"></canvas>
                        </div>
                    </div>

                    <div class="lg:col-span-5 bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                        <h3 class="font-bold text-slate-700 mb-6 flex items-center text-lg">
                            <i class="bi bi-pie-chart-fill text-indigo-500 me-3"></i>Distribusi Pekerjaan
                        </h3>
                        <div class="h-72 w-full">
                            <canvas id="chartPekerjaan"></canvas>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h3 class="font-bold text-slate-800 text-xl">Daftar Kunjungan</h3>
        <p class="text-xs text-slate-400 mt-1">Data yang muncul akan otomatis menjadi sumber laporan export</p>
    </div>

    <div class="flex items-center gap-3" x-data="{ openFilter: false, openExport: false }">
        
        <div class="relative">
            <button @click="openFilter = !openFilter" 
                class="p-3 bg-white border border-slate-100 text-slate-600 hover:bg-slate-50 rounded-2xl shadow-sm transition-all"
                title="Filter Tanggal">
                <i class="bi bi-calendar3 text-lg"></i>
            </button>

            <div x-show="openFilter" @click.outside="openFilter = false"
                class="absolute right-0 mt-3 w-[280px] bg-white border border-slate-100 rounded-[2rem] shadow-2xl p-6 z-50"
                style="display: none;">
                <form action="{{ route('admin.data-tamu') }}" method="GET" class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-sm font-semibold outline-none focus:ring-2 focus:ring-indigo-500/20">
                    </div>
                    <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-md">
                        Terapkan Filter
                    </button>
                    @if(request('start_date'))
                        <a href="{{ route('admin.data-tamu') }}" class="block text-center text-[10px] text-rose-500 font-bold uppercase tracking-widest mt-2">Reset Filter</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="relative">
            <button @click="openExport = !openExport" 
                class="flex items-center gap-2 px-6 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-lg transition-all">
                <i class="bi bi-file-earmark-arrow-down"></i>
                <span>Export</span>
            </button>

            <div x-show="openExport" @click.outside="openExport = false"
    class="absolute right-0 mt-3 w-[220px] bg-white border border-slate-100 rounded-[1.5rem] shadow-2xl p-3 z-50"
    style="display: none;">
    
    <a href="{{ route('admin.export.excel', request()->query()) }}" 
   class="flex items-center gap-3 p-3 hover:bg-emerald-50 text-emerald-600 rounded-xl transition-all group">
    <i class="bi bi-file-earmark-excel-fill text-xl"></i>
    <span class="text-xs font-bold text-slate-700">Format Excel (CSV)</span>
</a>

    <div class="h-px bg-slate-100 my-2"></div>

    <a href="javascript:void(0)" onclick="window.print()" 
   class="flex items-center gap-3 p-3 hover:bg-rose-50 text-rose-600 rounded-xl transition-all group">
    <i class="bi bi-file-earmark-pdf-fill text-xl"></i>
    <div class="flex flex-col text-left">
        <span class="text-xs font-bold text-slate-700">Cetak Laporan (PDF)</span>
        <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wider">Hanya Tabel</span>
    </div>
</a>
</div>
        </div>

    </div>
</div>

                    <div id="area-cetak" class="overflow-x-auto ">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-slate-400 text-[11px] uppercase tracking-[2px] font-bold bg-slate-50/50 border-b">
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">Identitas & Instansi</th>
                                    
                                    <th class="px-6 py-4">Keperluan</th>
                                    <th class="px-6 py-4 text-center">Berkas</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($tamu as $index => $t)
                                <tr class="hover:bg-slate-50/80 transition-all group">
                                    <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $index + 1 }}</td>
                                    
                                   <td class="px-6 py-5">
    <div class="flex items-center gap-3">
        
        <img src="{{ asset('fototamu/' . $t->foto) }}" 
             class="w-11 h-11 object-cover rounded-xl cursor-pointer ring-2 ring-white shadow-sm hover:scale-105 transition-transform" 
             onclick="openPhotoModal(this, '{{ addslashes($t->nama) }}', '{{ addslashes($t->instansi_asal) }}')">

        <div class="min-w-0">

            <!-- Nama -->
            <div class="text-sm font-bold text-slate-800 leading-tight">
                {{ $t->nama }}
            </div>

            <!-- Instansi -->
            <div class="text-xs text-slate-500 font-semibold truncate">
                {{ $t->instansi_asal }}
            </div>

            <!-- pekerjaan + waktu -->
            <div class="flex items-center gap-2 mt-1 flex-wrap">

                <span class="text-[9px] px-1.5 py-0.5 bg-indigo-50 text-indigo-600 rounded font-bold uppercase">
                    {{ $t->pekerjaan }}
                </span>

                <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap">
                    <i class="bi bi-clock me-1"></i>
                    {{ $t->created_at->format('d/m H:i') }}
                </span>

            </div>

        </div>

    </div>
</td>

                                    <td class="px-6 py-5">
    <div class="mb-2">
        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
            <i class="bi bi-geo-alt-fill"></i> Ke: {{ $t->bidang_tujuan }}
        </span>
    </div>
    <div class="group/text relative">
        <p class="text-sm text-slate-950 font-medium leading-relaxed max-w-[250px] line-clamp-2">
            {{ $t->keperluan }}
        </p>
        <button type="button" 
                onclick="openDetailModal('{{ addslashes($t->nama) }}', '{{ addslashes($t->keperluan) }}')"
                class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 mt-1 flex items-center gap-1 transition-colors">
            Lihat Detail <i class="bi bi-arrow-right-short"></i>
        </button>
    </div>
</td>

                                    <td class="px-6 py-5 text-center">
                                        @if($t->berkas)
                                            <a href="{{ asset('berkas/' . $t->berkas) }}" target="_blank" 
                                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100" 
                                               title="Lihat Berkas">
                                                <i class="bi bi-file-earmark-text-fill"></i>
                                            </a>
                                        @else
                                            <span class="text-[9px] font-bold text-slate-300 uppercase italic">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-center">
    <div class="flex justify-center gap-1">
        <a href="{{ route('admin.edit', $t->id) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors">
            <i class="bi bi-pencil-square"></i>
        </a>
        
        <form id="delete-form-{{ $t->id }}" action="{{ route('admin.delete', $t->id) }}" method="POST" class="hidden">
            @csrf 
            @method('DELETE')
        </form>

        <button type="button" onclick="confirmDelete('{{ $t->id }}')" class="p-2 text-red-400 hover:bg-red-50 rounded-lg transition-colors">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center text-slate-400 italic">
                                        Belum ada data kunjungan tamu.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="photoModal" class="fixed inset-0 z-[100] hidden bg-slate-900/90 backdrop-blur-md p-4 flex items-center justify-center" onclick="closePhotoModal()">
        <div class="max-w-sm w-full animate-in zoom-in duration-300" onclick="event.stopPropagation()">
            <img id="modalPhoto" src="" class="w-full h-auto rounded-[2rem] shadow-2xl border-4 border-white/20">
            <div class="bg-white mt-6 p-6 rounded-[2rem] text-center shadow-xl">
                <h4 id="modalName" class="font-black text-slate-800 text-lg"></h4>
                <p id="modalInstansi" class="text-slate-500 text-sm font-medium"></p>
                <button onclick="closePhotoModal()" class="mt-4 text-indigo-600 font-bold text-sm">Tutup</button>
            </div>
        </div>
    </div>

     <div id="detailModal" class="fixed inset-0 z-[100] hidden bg-slate-900/90 backdrop-blur-md flex items-center justify-center p-6" onclick="closeDetailModal()">
        <div class="relative max-w-xl w-full bg-white rounded-[2.5rem] overflow-hidden shadow-2xl animate-zoomIn" onclick="event.stopPropagation()">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-1">Detail Kunjungan</p>
                        <h3 id="detailName" class="text-2xl font-black text-slate-800 leading-tight uppercase"></h3>
                    </div>
                    <button onclick="closeDetailModal()" class="w-10 h-10 bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 rounded-2xl flex items-center justify-center transition-all">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1  text-black text-[9px] font-bold rounded-lg uppercase tracking-wider">
                            <span id="detailBidang"></span>
                        </span>
                    </div>
                    <p id="detailText" class="text-slate-700 leading-relaxed font-medium italic"></p>
                </div>
                <div class="mt-8">
                    <button onclick="closeDetailModal()" class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-blue-600 transition-all shadow-lg">Tutup Detail</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>

        function openDetailModal(name, bidang, keperluan) {
            document.getElementById('detailName').textContent = name;
            document.getElementById('detailBidang').textContent = bidang;
            document.getElementById('detailText').textContent = keperluan;
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden'); modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden'); modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }
        // 1. Fungsi Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data tamu ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', // Warna merah tailwind
            cancelButtonColor: '#64748b',  // Warna slate tailwind
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl px-6 py-3 font-bold uppercase text-xs tracking-widest',
                cancelButton: 'rounded-xl px-6 py-3 font-bold uppercase text-xs tracking-widest'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Jalankan submit form sesuai ID yang diklik
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    // 2. Notifikasi Berhasil (Muncul jika ada session success)
    @if(session('success'))
        Swal.fire({
            title: 'BERHASIL!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-[2rem]'
            }
        });
    @endif


        function openPhotoModal(el, name, instansi) {
            document.getElementById('modalPhoto').src = el.src;
            document.getElementById('modalName').innerText = name;
            document.getElementById('modalInstansi').innerText = instansi;
            document.getElementById('photoModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            document.getElementById('photoModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // INITIALIZE CHART
        document.addEventListener('DOMContentLoaded', function() {
            const ctxK = document.getElementById('chartKedatangan').getContext('2d');
            new Chart(ctxK, {
                type: 'bar',
                data: {
                    labels: [@foreach($kedatanganPerHari as $d) '{{ $d["tanggal"] }}', @endforeach],
                    datasets: [{
                        label: 'Tamu',
                        data: [@foreach($kedatanganPerHari as $d) {{ $d["jumlah"] }}, @endforeach],
                        backgroundColor: '#6366f1',
                        borderRadius: 5
                    }]
                },
                options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            const ctxP = document.getElementById('chartPekerjaan').getContext('2d');
new Chart(ctxP, {
    type: 'bar', // UBAH INI: dari 'doughnut' menjadi 'bar'
    data: {
        labels: [@foreach($tamuPerPekerjaan as $p) '{{ $p->pekerjaan }}', @endforeach],
        datasets: [{
            label: 'Jumlah Pekerjaan', // Tambahkan label jika perlu
            data: [@foreach($tamuPerPekerjaan as $p) {{ $p->jumlah }}, @endforeach],
            backgroundColor: ['#6366f1', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444'],
            borderRadius: 8 // Opsional: agar batang lebih modern (tumpul di ujung)
        }]
    },
    options: { 
        maintainAspectRatio: false,
        // cutout: '70%' // HAPUS INI: Properti cutout hanya untuk doughnut/pie
        plugins: {
            legend: { display: false } // Sembunyikan legend agar lebih bersih
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
        });

        
    </script>
</body>
</html>