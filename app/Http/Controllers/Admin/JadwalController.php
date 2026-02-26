<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPimpinan;
use App\Models\JadwalHistory;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function indexJadwal()
    {
        /** * PERBAIKAN UTAMA: 
         * Mengambil data Pegawai yang memiliki relasi 'jadwal'. 
         * Gunakan with('jadwal') agar fungsi $pegawai->jadwal di Blade terbaca.
         *
         */
        $jadwalHariIni = JadwalPimpinan::whereDate('mulai_tgl', '<=', today())
        ->whereDate('sampai_tgl', '>=', today())
        ->first();
        $pegawais = Pegawai::with(['jadwal' => function($query) {
    $query->whereDate('sampai_tgl', '>=', today()) // ⬅ FILTER DI SINI
          ->orderBy('mulai_tgl', 'asc');
}])->orderBy('nama', 'asc')->get();

        // Variabel $jadwal tetap diambil jika masih dibutuhkan untuk bagian lain
        $jadwal = JadwalPimpinan::with('pegawai')->latest()->get(); 
        
        return view('admin.jadwal-pimpinan', compact('jadwal', 'pegawais'));
    }

    public function historyJadwal(Request $request)
    {
        $query = JadwalHistory::with(['pegawai' => function($q) {
            $q->withTrashed();
        }]);

        if ($request->filled('pejabat')) { 
            $query->where('pegawai_id', $request->pejabat); 
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('tgl_kejadian', '>=', $request->start_date)
                  ->whereDate('tgl_kejadian', '<=', $request->end_date);
        }

        $histories = $query->latest('tgl_kejadian')->get();
        $daftar_pejabat = Pegawai::orderBy('nama', 'asc')->get();

        return view('admin.jadwal-history', compact('histories', 'daftar_pejabat'));
    }

    public function simpanJadwal(Request $request)
{
    $request->validate([
        'pegawai_id' => 'required|exists:pegawai,id', 
        'jabatan'    => 'required', 
        'status'     => 'required',
        'mulai_tgl'  => 'required|date',
        'sampai_tgl' => 'required|date|after_or_equal:mulai_tgl',
    ]);

    // 1. Ambil data pegawai
    $pegawai = Pegawai::findOrFail($request->pegawai_id);

    // 2. LOGIKA PENGECEKAN BENTROK (OVERLAP)
    // Mencari apakah ada jadwal yang bersinggungan di rentang tanggal yang diinput
    $bentrok = JadwalPimpinan::where('pegawai_id', $request->pegawai_id)
        ->where(function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                // Skenario 1: Tanggal mulai baru berada di tengah jadwal yang sudah ada
                $q->where('mulai_tgl', '<=', $request->mulai_tgl)
                  ->where('sampai_tgl', '>=', $request->mulai_tgl);
            })->orWhere(function ($q) use ($request) {
                // Skenario 2: Tanggal selesai baru berada di tengah jadwal yang sudah ada
                $q->where('mulai_tgl', '<=', $request->sampai_tgl)
                  ->where('sampai_tgl', '>=', $request->sampai_tgl);
            })->orWhere(function ($q) use ($request) {
                // Skenario 3: Jadwal baru mencakup/menelan jadwal yang sudah ada
                $q->where('mulai_tgl', '>=', $request->mulai_tgl)
                  ->where('sampai_tgl', '<=', $request->sampai_tgl);
            });
        })->exists();

    if ($bentrok) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal! Pimpinan ini sudah memiliki agenda lain pada rentang tanggal tersebut.');
    }

    // 3. Simpan ke Tabel Utama (jadwal_pimpinan)
    JadwalPimpinan::create([
        'pegawai_id' => $pegawai->id,
        'nama'       => $pegawai->nama,
        'jabatan'    => $request->jabatan,
        'status'     => $request->status,
        'info_utama' => $request->info_utama,
        'mulai_tgl'  => $request->mulai_tgl,
        'sampai_tgl' => $request->sampai_tgl,
      
    ]);

    // 4. Simpan ke Riwayat (jadwal_history)
    JadwalHistory::create([
        'pegawai_id'   => $pegawai->id,
        'nip'          => $pegawai->nip ?? '-',
        'nama'         => $pegawai->nama,
        'jabatan'      => $request->jabatan,
        'status'       => $request->status,
        'info_utama'   => $request->info_utama,
        'mulai_tgl'    => $request->mulai_tgl,
        'sampai_tgl'   => $request->sampai_tgl,
     
        'tgl_kejadian' => now(),
    ]);

    return redirect()->back()->with('success', 'Agenda berhasil ditambahkan!');
}

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = JadwalPimpinan::with('pegawai')->findOrFail($id);
        $jadwal->update($request->all());

        JadwalHistory::create([
            'pegawai_id'   => $jadwal->pegawai_id,
            'nip'          => $jadwal->pegawai->nip ?? '-',
            'nama'         => $jadwal->pegawai->nama,
            'jabatan'      => $jadwal->jabatan,
            'status'       => $jadwal->status,
            'info_utama'   => $jadwal->info_utama,
            'mulai_tgl'    => $jadwal->mulai_tgl,
            'sampai_tgl'   => $jadwal->sampai_tgl,
         
            'tgl_kejadian' => now(), 
        ]);

        return redirect()->back()->with('success', 'Status pimpinan berhasil diperbarui!');
    }

    /**
     * Menampilkan riwayat jadwal khusus untuk tampilan Kadis.
     * Nama method disesuaikan dengan route('kadis.riwayat-jadwal')
     */
    public function history(Request $request)
    {
        // 1. Inisialisasi query dari model JadwalHistory
        // Menggunakan withTrashed() agar jika data pegawai dihapus, riwayat tetap tampil
        $query = JadwalHistory::with(['pegawai' => function($q) {
            $q->withTrashed();
        }]);

        // 2. Filter berdasarkan Pejabat/Pegawai
        if ($request->filled('pejabat')) { 
            $query->where('pegawai_id', $request->pejabat); 
        }

        // 3. Filter berdasarkan rentang tanggal kejadian (kapan status diubah)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('tgl_kejadian', '>=', $request->start_date)
                  ->whereDate('tgl_kejadian', '<=', $request->end_date);
        }

        // 4. Ambil data dengan urutan terbaru
        $histories = $query->latest('tgl_kejadian')->get();

        // 5. Ambil daftar pegawai untuk dropdown filter di view
        $daftar_pejabat = Pegawai::orderBy('nama', 'asc')->get();

        // 6. Return ke view khusus kadis
        return view('kadis.riwayat-jadwal', compact('histories', 'daftar_pejabat'));
    }
    public function hapusJadwal($id)
    {
        JadwalPimpinan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Agenda pimpinan berhasil dihapus!');
    }
}