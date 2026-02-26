<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use App\Models\ArsipSurat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $tamuHariIni = BukuTamu::whereDate('created_at', Carbon::today())->count();
        $tamuBulanIni = BukuTamu::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();
        $totalTamu = BukuTamu::count();

        $statsHariIni = BukuTamu::whereDate('created_at', Carbon::today())
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'ASN' THEN 1 ELSE 0 END) as pns")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Swasta' THEN 1 ELSE 0 END) as swasta")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Wartawan' THEN 1 ELSE 0 END) as wartawan")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Wirausaha' THEN 1 ELSE 0 END) as wirausaha")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Mahasiswa/Pelajar' THEN 1 ELSE 0 END) as pelajar")
            ->first();

        $statsBulanIni = BukuTamu::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'ASN' THEN 1 ELSE 0 END) as pns")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Swasta' THEN 1 ELSE 0 END) as swasta")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Wartawan' THEN 1 ELSE 0 END) as wartawan")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Wirausaha' THEN 1 ELSE 0 END) as wirausaha")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Mahasiswa/Pelajar' THEN 1 ELSE 0 END) as pelajar")
            ->first();

        $statsTotal = BukuTamu::selectRaw("SUM(CASE WHEN pekerjaan = 'ASN' THEN 1 ELSE 0 END) as pns")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Swasta' THEN 1 ELSE 0 END) as swasta")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Wartawan' THEN 1 ELSE 0 END) as wartawan")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Wirausaha' THEN 1 ELSE 0 END) as wirausaha")
            ->selectRaw("SUM(CASE WHEN pekerjaan = 'Mahasiswa/Pelajar' THEN 1 ELSE 0 END) as pelajar")
            ->first();

        $totalSuratMasuk = ArsipSurat::where('jenis', 'masuk')->count();
        $totalSuratKeluar = ArsipSurat::where('jenis', 'keluar')->count();

        return view('admin.dashboard', compact(
            'tamuHariIni', 'tamuBulanIni', 'totalTamu', 
            'statsHariIni', 'statsBulanIni', 'statsTotal', 'totalSuratMasuk','totalSuratKeluar'
        ));
    }
}