<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah user sudah login di guard admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu');
        }

        // 2. Ambil user yang sedang login
        $user = Auth::guard('admin')->user();

        // 3. Izinkan jika rolenya superadmin, admin, atau kadis
        // Ini kunci agar Kadis tidak dianggap 'tamu' oleh middleware ini
        if (in_array($user->role, ['superadmin', 'admin', 'kadis'])) {
            return $next($request);
        }

        // Jika login tapi role tidak valid, tendang keluar
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('error', 'Akses tidak diizinkan.');
    }
}