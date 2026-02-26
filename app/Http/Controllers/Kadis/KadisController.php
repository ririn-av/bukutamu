<?php

namespace App\Http\Controllers\Kadis;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KadisController extends Controller
{
    public function dashboardKadis()
    {
        if (Auth::guard('admin')->user()->role !== 'kadis') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses khusus Kadis!');
        }

        $tamuHariIni = BukuTamu::whereDate('created_at', Carbon::today())->count();
        $tamuBulanIni = BukuTamu::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();
        $totalTamu = BukuTamu::count();

        $statsBidang = BukuTamu::select('bidang_tujuan', \Illuminate\Support\Facades\DB::raw('count(*) as jumlah'))
            ->groupBy('bidang_tujuan')
            ->get();

        $statsPekerjaan = BukuTamu::select('pekerjaan', \Illuminate\Support\Facades\DB::raw('count(*) as jumlah'))
            ->groupBy('pekerjaan')
            ->get();

        return view('kadis.dashboard', compact(
            'tamuHariIni', 
            'tamuBulanIni', 
            'totalTamu', 
            'statsBidang', 
            'statsPekerjaan'
        ));
    }

    public function laporanTamu(Request $request)
    {
        if (Auth::guard('admin')->user()->role !== 'kadis') {
            return redirect()->route('admin.dashboard')->with('error', 'Akses khusus Kadis!');
        }

        $query = BukuTamu::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
        }

        $tamu = $query->orderBy('created_at', 'desc')->get();
        
        $bulanSekarang = Carbon::now()->month;
        $tahunSekarang = Carbon::now()->year;
        
        $dataBulanIni = BukuTamu::whereMonth('created_at', $bulanSekarang)
            ->whereYear('created_at', $tahunSekarang)
            ->get()
            ->groupBy(function($item) {
                return Carbon::parse($item->created_at)->format('j'); 
            });
        
        $kedatanganPerHari = [];
        for ($hari = 1; $hari <= Carbon::now()->daysInMonth; $hari++) {
            $kedatanganPerHari[] = [
                'tanggal' => $hari,
                'jumlah' => isset($dataBulanIni[$hari]) ? $dataBulanIni[$hari]->count() : 0
            ];
        }
        
        $tamuPerPekerjaan = BukuTamu::select('pekerjaan', \Illuminate\Support\Facades\DB::raw('count(*) as jumlah'))
            ->groupBy('pekerjaan')
            ->get();

        return view('kadis.laporan-tamu', compact('tamu', 'kedatanganPerHari', 'tamuPerPekerjaan'));
    }
    // Tambahkan method ini di bagian bawah class JadwalController
    public function history(Request $request)
    {
        // 1. Ambil data history dengan relasi pegawai (termasuk yang sudah di-soft delete)
        $query = JadwalHistory::with(['pegawai' => function($q) {
            $q->withTrashed();
        }]);

        // 2. Logika Filter Pejabat
        if ($request->filled('pejabat')) { 
            $query->where('pegawai_id', $request->pejabat); 
        }

        // 3. Logika Filter Rentang Tanggal (Berdasarkan tgl_kejadian/input)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('tgl_kejadian', '>=', $request->start_date)
                  ->whereDate('tgl_kejadian', '<=', $request->end_date);
        }

        // 4. Ambil data terbaru
        $histories = $query->latest('tgl_kejadian')->get();

        // 5. Ambil daftar pegawai untuk dropdown filter
        $daftar_pejabat = Pegawai::orderBy('nama', 'asc')->get();

        // 6. Return ke view kadis (Pastikan file blade ada di resources/views/kadis/history.blade.php)
        return view('kadis.history', compact('histories', 'daftar_pejabat'));
    }
}