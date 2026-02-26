<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArsipSurat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    public function suratMasuk()
    {
        $surat = ArsipSurat::where('jenis', 'masuk')->latest()->get();
        return view('admin.surat-masuk', compact('surat'));
    }

    public function suratKeluar()
    {
        $surat = ArsipSurat::where('jenis', 'keluar')->latest()->get();
        return view('admin.surat-keluar', compact('surat'));
    }

    public function simpanArsip(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:masuk,keluar',
            'tanggal_surat' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'pengirim_penerima' => 'required|string|max:255',
            'perihal' => 'required',
            'bidang' => 'required',
            'file_surat' => 'nullable|mimes:pdf,jpg,png|max:2048'
        ], [
            'file_surat.max' => 'Ukuran file maksimal adalah 2MB.',
            'file_surat.mimes' => 'Format file harus PDF, JPG, atau PNG.'
        ]);

        $data = $request->all();

        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $tujuanFolder = 'surat/' . $request->jenis;
            $file->move(public_path($tujuanFolder), $namaFile);
            $data['file_surat'] = $tujuanFolder . '/' . $namaFile;
        }

        ArsipSurat::create($data);
        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function editsurat($id)
    {
        $surat = ArsipSurat::findOrFail($id);
        return view('admin.editsurat', compact('surat'));
    }

    public function hapusArsip($id)
    {
        $surat = ArsipSurat::findOrFail($id);
        if ($surat->file_surat && file_exists(public_path('surat/' . $surat->file_surat))) {
            unlink(public_path('surat/' . $surat->file_surat));
        }
        $surat->delete();
        return back()->with('success', 'Arsip surat berhasil dihapus!');
    }
}