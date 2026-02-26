<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BukuTamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TamuController extends Controller
{
    public function dataTamu(Request $request)
    {
        if (Auth::guard('admin')->user()->role === 'kadis') {
            return redirect()->route('kadis.laporan-tamu');
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
            ->groupBy(fn($item) => Carbon::parse($item->created_at)->format('j'));
        
        $kedatanganPerHari = [];
        for ($hari = 1; $hari <= Carbon::now()->daysInMonth; $hari++) {
            $kedatanganPerHari[] = [
                'tanggal' => $hari,
                'jumlah' => isset($dataBulanIni[$hari]) ? $dataBulanIni[$hari]->count() : 0
            ];
        }
        
        $tamuPerPekerjaan = BukuTamu::select('pekerjaan', DB::raw('count(*) as jumlah'))
            ->groupBy('pekerjaan')->get();

        return view('admin.data-tamu', compact('tamu', 'kedatanganPerHari', 'tamuPerPekerjaan'));
    }

    public function exportExcel(Request $request)
    {
        $query = BukuTamu::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
        }
        $tamu = $query->orderBy('created_at', 'desc')->get();
        $fileName = 'laporan_tamu_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use($tamu) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'Pekerjaan', 'Instansi', 'Keperluan', 'Tanggal']);
            foreach ($tamu as $key => $item) {
                fputcsv($file, [
                    $key + 1, $item->nama, $item->pekerjaan, $item->instansi, $item->keperluan, $item->created_at->format('d/m/Y H:i')
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function dataTamuHariIni()
    {
        $tamu = BukuTamu::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
        return view('admin.data-tamu-hari-ini', compact('tamu'));
    }

    public function edit($id)
    {
        $tamu = BukuTamu::findOrFail($id);
        return view('admin.edit', compact('tamu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required', 'pekerjaan' => 'required', 'instansi_asal' => 'required', 'bidang_tujuan' => 'required', 'keperluan' => 'required']);
        $tamu = BukuTamu::findOrFail($id);
        $tamu->update($request->all());
        return redirect()->route('admin.data-tamu')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        BukuTamu::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data tamu berhasil dihapus!');
    }

    public function cekTamuBaru()
    {
        $tamuHariIni = BukuTamu::whereDate('created_at', Carbon::today())->orderBy('created_at', 'DESC')->get();
        return response()->json([
            'jumlah' => $tamuHariIni->count(),
            'data' => $tamuHariIni,
            'latest_id' => $tamuHariIni->first() ? $tamuHariIni->first()->id : 0
        ]);
    }
}
