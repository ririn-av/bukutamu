<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tamu Hari Ini - Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .animate-zoomIn {
    animation: zoomIn 0.25s ease;
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-active { 
            background: linear-gradient(to right, #2563eb, #3b82f6); 
            color: white !important; 
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.95) translateY(10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-zoomIn { animation: zoomIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
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
                        <p class="text-[8px] font-bold text-blue-400 tracking-[0.2em] leading-none uppercase">Indragiri Hulu</p>
                    </div>
                </div>
            </div>

            <nav class="px-6 space-y-2 flex-1 overflow-y-auto">
                <p class="text-[11px] font-bold text-slate-500 uppercase px-3 mb-4 tracking-[0.15em]">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white {{ Request::is('admin/dashboard') ? 'sidebar-active' : '' }}">
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
                        <a href="{{ route('admin.data-tamu.hari-ini') }}" class="block px-4 py-2 text-[13px] font-bold text-white rounded-lg bg-slate-800/50">Hari Ini</a>
                        <a href="{{ route('admin.data-tamu') }}" class="block px-4 py-2 text-[13px] rounded-lg hover:bg-slate-800 hover:text-white transition-all">Total Tamu</a>
                    </div>
                </div>

                <a href="{{ route('admin.data-pegawai') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-person-badge-fill text-lg"></i>
                    <span>Data Pegawai</span>
                </a>
                <a href="{{ route('admin.jadwal-pimpinan') }}" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-semibold transition-all duration-300 hover:bg-slate-800 hover:text-white">
                    <i class="bi bi-calendar2-check-fill text-lg"></i>
                    <span>Jadwal Pimpinan</span>
                </a>
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
                    <p class="text-[11px] text-slate-500 mt-1.5">Daftar kunjungan pada <span class="font-bold text-slate-700">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span></p>
                </div>
                
                <div class="flex items-center gap-6">
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
                        <div x-show="openProfile" @click.outside="openProfile = false" x-transition class="absolute top-full right-0 mt-3 w-48 bg-white border border-slate-100 rounded-2xl shadow-2xl p-2 z-50" style="display: none;">
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

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/60 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h5 class="font-bold text-slate-700 flex items-center gap-3">
                        <i class="bi bi-person-lines-fill text-blue-600"></i> Antrean Kunjungan
                    </h5>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-slate-400 text-[11px] uppercase tracking-[0.15em] font-bold border-b border-slate-100">
                                <th class="px-6 py-5">No</th>
                                <th class="px-6 py-5">Profil</th>
                                <th class="px-6 py-5">Identitas & Instansi</th>
                                <th class="px-6 py-5">Keperluan</th>
                                <th class="px-6 py-5 text-center">Berkas</th>
                                <th class="px-6 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($tamu as $index => $t)
                            <tr class="group hover:bg-blue-50/30 transition-all duration-200">
                                <td class="px-6 py-5 text-slate-400 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-5">
                                    <div class="relative w-12 h-12">
                                        @if($t->foto)
                                            <img src="{{ asset('fototamu/' . $t->foto) }}" 
                                                 class="w-12 h-12 rounded-xl object-cover shadow-sm ring-2 ring-white group-hover:ring-blue-100 transition-all cursor-pointer"
                                                 onclick="openPhotoModal(this, '{{ addslashes($t->nama) }}', '{{ addslashes($t->instansi_asal) }}')">
                                        @else
                                            <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 border border-slate-200">
                                                <i class="bi bi-person text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="font-bold text-slate-800 uppercase text-sm tracking-tight leading-none mb-1.5">{{ $t->nama }}</p>
                                    <div class="flex flex-col gap-1.5">
                                        <p class="text-[11px] text-slate-400 flex items-center gap-1 font-medium">
                                            <i class="bi bi-building text-[10px]"></i> {{ $t->instansi_asal }}
                                        </p>
                                        <div>
                                            <span class="inline-block px-2 py-0.5 rounded-md text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200/50 group-hover:bg-white group-hover:text-blue-600 transition-all">
                                                {{ $t->pekerjaan }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="mb-2">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-100">
                                            <i class="bi bi-geo-alt-fill"></i> Ke: {{ $t->bidang_tujuan }}
                                        </span>
                                    </div>
                                    <div class="relative">
                                        <p class="text-sm text-slate-950 font-medium leading-relaxed max-w-[250px] line-clamp-2 italic">
                                            "{{ $t->keperluan }}"
                                        </p>
                                        @if(strlen($t->keperluan) > 60)
                                            <button onclick="openDetailModal('{{ addslashes($t->nama) }}', '{{ addslashes($t->bidang_tujuan) }}', '{{ addslashes($t->keperluan) }}')" 
                                                    class="text-[10px] font-extrabold text-blue-600 hover:text-blue-800 uppercase mt-1 tracking-wider flex items-center gap-1">
                                                Lihat Detail <i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($t->berkas)
                                        <a href="{{ asset('berkas/' . $t->berkas) }}" target="_blank" class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm flex items-center justify-center mx-auto">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                    @else
                                        <span class="text-[9px] font-bold text-slate-300 uppercase italic">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.edit', $t->id) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 rounded-xl hover:border-amber-500 hover:text-amber-500 transition-all shadow-sm">
                                            <i class="bi bi-pencil-square text-sm"></i>
                                        </a>
                                        <form id="delete-form-{{ $t->id }}" action="{{ route('admin.delete', $t->id) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('{{ $t->id }}', '{{ addslashes($t->nama) }}')" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-400 rounded-xl hover:border-red-500 hover:text-red-500 transition-all shadow-sm">
                                                <i class="bi bi-trash3 text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-6 py-20 text-center text-slate-400 font-bold uppercase tracking-widest">Belum ada tamu hari ini</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="photoModal" class="fixed inset-0 z-[100] hidden bg-slate-900/90 backdrop-blur-md flex items-center justify-center p-6" onclick="closePhotoModal()">
        <div class="relative max-w-2xl w-full bg-white rounded-[3rem] overflow-hidden shadow-2xl animate-zoomIn" onclick="event.stopPropagation()">
            <button class="absolute top-6 right-6 z-10 w-10 h-10 bg-black/10 hover:bg-red-500 text-white rounded-full flex items-center justify-center transition-all" onclick="closePhotoModal()">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="p-2"><img id="modalPhoto" src="" class="w-full h-auto max-h-[70vh] object-cover rounded-[2.5rem]"></div>
            <div class="p-8 text-center bg-gradient-to-b from-white to-slate-50">
                <p class="text-xs font-black text-blue-500 uppercase tracking-widest mb-1">Profil Pengunjung</p>
                <h5 id="modalName" class="text-3xl font-black text-slate-800 uppercase tracking-tighter"></h5>
                <p id="modalInstansi" class="text-slate-500 font-bold mt-2 flex items-center justify-center gap-2"><i class="bi bi-building"></i> <span></span></p>
            </div>
        </div>
    </div>
<div id="detailModal"
    class="fixed inset-0 z-[100] hidden bg-slate-900/90 backdrop-blur-md flex items-center justify-center p-6"
    onclick="closeDetailModal()">

    <div class="relative max-w-xl w-full bg-white rounded-[2.5rem] shadow-2xl animate-zoomIn"
        onclick="event.stopPropagation()">

        <div class="p-8 space-y-6">

            <!-- HEADER -->
            <div class="flex justify-between items-start">

                <div>
                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em] mb-1">
                        Detail Kunjungan
                    </p>

                    <h3 id="detailName"
                        class="text-2xl font-black text-slate-800 leading-tight uppercase break-words">
                    </h3>
                </div>

                <button onclick="closeDetailModal()"
                    class="w-10 h-10 bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-500 rounded-2xl flex items-center justify-center transition-all">

                    <i class="bi bi-x-lg"></i>

                </button>

            </div>


            <!-- CONTENT -->
            <div class="bg-slate-50 rounded-3xl p-6 border border-slate-100 space-y-5">


                <!-- TUJUAN -->
                <div>

                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-wider mb-2">
                        Tujuan
                    </p>

                    <div id="detailBidang"
class="bg-blue-600 text-white text-sm font-semibold rounded-xl p-4
break-all whitespace-normal w-full">
</div>

                </div>


                <!-- KEPERLUAN -->
                <div>

                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Keperluan
                    </p>

                    <div id="detailText"
                        class="text-slate-700 leading-relaxed font-medium italic break-words whitespace-pre-line">
                    </div>

                </div>


            </div>


            <!-- BUTTON -->
            <button onclick="closeDetailModal()"
                class="w-full py-4 bg-slate-900 text-white font-bold rounded-2xl hover:bg-blue-600 transition-all shadow-lg">

                Tutup Detail

            </button>


        </div>

    </div>

</div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Yakin menghapus?',
                html: `Data tamu <b>${nama}</b> akan dihapus secara permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', 
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-[2.5rem]', confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold' }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
            })
        }

        @if(session('success'))
            Swal.fire({ title: 'Berhasil!', text: "{{ session('success') }}", icon: 'success', confirmButtonColor: '#2563eb', customClass: { popup: 'rounded-[2.5rem]' } });
        @endif

        function openPhotoModal(imgElement, name, instansi) {
            document.getElementById('modalPhoto').src = imgElement.src;
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalInstansi').querySelector('span').textContent = instansi;
            const modal = document.getElementById('photoModal');
            modal.classList.remove('hidden'); modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden'); modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

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

        document.addEventListener('keydown', (e) => { 
            if(e.key === 'Escape') { closePhotoModal(); closeDetailModal(); }
        });
    </script>
</body>
</html>