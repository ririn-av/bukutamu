<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Arsip - Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-900">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-xl border border-slate-100 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-2xl font-extrabold text-slate-800">Edit Arsip Surat</h3>
                    <p class="text-sm text-slate-500 mt-1">Ubah informasi dokumen yang sudah diarsipkan</p>
                </div>
                <a href="{{ route('admin.surat-masuk') }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                    <i class="bi bi-x-lg text-lg"></i>
                </a>
            </div>

            <form action="{{ route('admin.arsip.update', $surat->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-1">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ $surat->tanggal_surat }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-1">Nomor Surat</label>
                        <input type="text" name="nomor_surat" value="{{ $surat->nomor_surat }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500/20 transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-1">Pengirim / Penerima</label>
                    <input type="text" name="pengirim_penerima" value="{{ $surat->pengirim_penerima }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-1">Perihal</label>
                    <textarea name="perihal" rows="3" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500/20 transition-all">{{ $surat->perihal }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-1">Bidang</label>
                        <select name="bidang" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-semibold outline-none focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer">
                            @foreach(['Sekretariat', 'E-Government', 'Informasi dan Komunikasi Publik', 'Statistik'] as $bidang)
                                <option value="{{ $bidang }}" {{ $surat->bidang == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest ml-1">Ganti File (Opsional)</label>
                        <div class="relative w-full px-5 py-3.5 bg-blue-50 border-2 border-dashed border-blue-200 rounded-2xl flex items-center gap-3 hover:bg-blue-100 transition-all cursor-pointer">
                            <i class="bi bi-cloud-arrow-up-fill text-blue-500 text-xl"></i>
                            <input type="file" name="file_surat" accept=".pdf,.jpg,.png" class="absolute inset-0 opacity-0 cursor-pointer">
                            <span class="text-xs font-bold text-blue-600">Klik untuk upload file baru</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 flex gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all">Update Data</button>
                    <a href="{{ route('admin.surat-masuk') }}" class="px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all text-center">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>