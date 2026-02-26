<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Pegawai; // Pastikan Model Pegawai di-import
use App\Models\JadwalPimpinan;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Carbon\Carbon; // Pastikan Carbon di-import untuk urusan tanggal

class GuestController extends Controller
{
    // Halaman dashboard guest (GANTI FUNCTION INDEX LAMA DENGAN INI)
    public function index()
    {
        $hariIni = Carbon::today();
        $tujuhHariKeDepan = Carbon::today()->addDays(7);

        // Ambil pegawai beserta jadwal yang masuk dalam rentang 7 hari ke depan
        $pegawais = Pegawai::with(['jadwal' => function($query) use ($hariIni, $tujuhHariKeDepan) {
            $query->where(function($q) use ($hariIni, $tujuhHariKeDepan) {
                // Logika: jadwal yang mulai_tgl atau sampai_tgl-nya ada di rentang 1 minggu ini
                $q->whereBetween('mulai_tgl', [$hariIni, $tujuhHariKeDepan])
                  ->orWhereBetween('sampai_tgl', [$hariIni, $tujuhHariKeDepan])
                  // Atau jadwal yang sedang berlangsung
                  ->orWhere(function($sub) use ($hariIni) {
                      $sub->where('mulai_tgl', '<=', $hariIni)
                          ->where('sampai_tgl', '>=', $hariIni);
                  });
            })->orderBy('mulai_tgl', 'asc'); 
        }])->get();

        // Pastikan nama view sesuai (guest.dashboard)
        return view('guest.dashboard', compact('pegawais'));
    }

    // Halaman form isi buku tamu
    public function create()
    {
        return view('guest.form');
    }

    // Simpan data buku tamu
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pekerjaan' => 'required|in:PNS,Swasta,Wirausaha,Wartawan,Mahasiswa/Pelajar',
            'instansi_asal' => 'required|string|max:255',
            'bidang_tujuan' => 'required|string',
            'keperluan' => 'required|string',
            'foto' => 'required|string',
            'berkas' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', 
        ], [
            'foto.required' => 'Foto wajib diambil! Silakan klik "Buka Kamera" untuk mengambil foto Anda.',
            'pekerjaan.required' => 'Pekerjaan wajib dipilih!',
            'berkas.mimes' => 'Format berkas harus PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'berkas.max' => 'Ukuran berkas maksimal 5MB.',
            'bidang_tujuan.required' => 'Bidang tujuan wajib dipilih!'
        ]);

        // Helper variabel untuk penamaan file
        $namaBersih = Str::slug($request->nama);
        $timestamp = Carbon::now()->format('Ymd_His');
        $uniqueId = Str::random(6);

        // 1. Proses Foto (Base64)
        $fotoBase64 = $request->foto;
        $foto_parts = explode(";base64,", $fotoBase64);
        $foto_decoded = base64_decode($foto_parts[1]);
        $namaFileFoto = "foto_{$namaBersih}_{$timestamp}_{$uniqueId}.png";
        
        $pathFoto = public_path('fototamu');
        if (!file_exists($pathFoto)) {
            mkdir($pathFoto, 0755, true);
        }
        file_put_contents($pathFoto . '/' . $namaFileFoto, $foto_decoded);

        // 2. Proses Berkas (File Upload)
        $namaFileBerkas = null;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $extension = $file->getClientOriginalExtension();
            $namaFileBerkas = "berkas_{$namaBersih}_{$timestamp}_{$uniqueId}.{$extension}";
            
            $pathBerkas = public_path('berkas');
            if (!file_exists($pathBerkas)) {
                mkdir($pathBerkas, 0755, true);
            }
            $file->move($pathBerkas, $namaFileBerkas);
        }

        // 3. Simpan ke Database
        BukuTamu::create([
            'nama' => $request->nama,
            'pekerjaan' => $request->pekerjaan,
            'instansi_asal' => $request->instansi_asal,
            'bidang_tujuan' => $request->bidang_tujuan,
            'keperluan' => $request->keperluan,
            'foto' => $namaFileFoto,
            'berkas' => $namaFileBerkas,
        ]);

        return redirect()->route('guest.dashboard')->with('success', 'Data kunjungan Anda telah berhasil dicatat.');
    }
}