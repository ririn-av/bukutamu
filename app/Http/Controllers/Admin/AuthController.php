<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);

            if ($admin->role === 'kadis') {
                return redirect()->route('kadis.dashboard');
            }
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function settings()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings', compact('admin'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password minimal harus 8 karakter.'
        ]);

        $user = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}