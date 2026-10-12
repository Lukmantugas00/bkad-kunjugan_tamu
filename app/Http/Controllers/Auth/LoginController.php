<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nip' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt([
            'nip' => $credentials['nip'],
            'password' => $credentials['password'],
            'aktif' => true,
        ])) {
            $request->session()->regenerate();

            $user = Auth::user();

            ActivityLogger::log(
                'Login',
                'Pengguna berhasil login sebagai '.$user->name
            );

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),

                'pimpinan' => redirect()->route('pimpinan.dashboard'),

                'petugas_piket' => redirect()->route('kunjungan.create'),

                'penerima_bidang' => redirect()->route(
                    'kunjungan.inbox',
                    ['kode' => $user->bidang->kode]
                ),

                default => redirect('/'),
            };
        }

        return back()
            ->withErrors([
                'nip' => 'NIP atau password salah atau akun tidak aktif.',
            ])
            ->onlyInput('nip');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLogger::log(
                'Logout',
                'Pengguna keluar dari sistem.'
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
