<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // --- MANAJEMEN USER ---
    public function manajemenUser()
    {
        if (Auth::guard('admin')->user()->role !== 'superadmin') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak!');
        }
        $users = Admin::all(); 
        return view('admin.manajemen-user', compact('users'));
    }

    public function simpanUser(Request $request)
    {
        if (Auth::guard('admin')->user()->role !== 'superadmin') { return redirect()->route('admin.dashboard'); }
        $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:admin,email', 'password' => 'required|min:6', 'role' => 'required|in:admin,kadis']);
        try {
            Admin::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password), 'role' => $request->role]);
            return redirect()->route('admin.manajemen-user')->with('success', 'Admin baru berhasil ditambahkan!');
        } catch (\Exception $e) { return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage()); }
    }

    public function hapusUser($id)
    {
        if (Auth::guard('admin')->user()->role !== 'superadmin') { return redirect()->route('admin.dashboard'); }
        $admin = Admin::findOrFail($id);
        if ($admin->id === Auth::guard('admin')->user()->id) { return back()->with('error', 'Tidak bisa menghapus akun sendiri!'); }
        $admin->delete();
        return back()->with('success', 'Akun admin berhasil dihapus!');
    }

    // --- MANAJEMEN PEGAWAI ---
    public function indexPegawai()
    {
        $pegawai = Pegawai::orderBy('nama', 'asc')->get();
        return view('admin.data-pegawai', compact('pegawai'));
    }

    public function simpanPegawai(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255', 
        'jabatan' => 'required|string', 
       
    ]);
    
    Pegawai::create($request->all());
    return redirect()->back()->with('success', 'Pegawai berhasil ditambahkan!');
}

    public function updatePegawai(Request $request, $id) {
    $request->validate([
        'nama' => 'required',
        'jabatan' => 'required'
        
    ]);

    $pegawai = Pegawai::findOrFail($id);
    $pegawai->update([
        'nama' => $request->nama,
        'nip' => $request->nip,
        'jabatan' => $request->jabatan
    ]);

    return redirect()->back()->with('success', 'Data pegawai berhasil diperbarui!');
    }

    public function hapusPegawai($id)
{
    $pegawai = Pegawai::findOrFail($id);
    
    // Hapus juga jadwal aktifnya di monitor pimpinan agar langsung hilang
    \App\Models\JadwalPimpinan::where('pegawai_id', $id)->delete();
    
    // Baru hapus pegawainya (Soft Delete)
    $pegawai->delete();

    return redirect()->back()->with('success', 'Pegawai berhasil dinonaktifkan.');
}
}