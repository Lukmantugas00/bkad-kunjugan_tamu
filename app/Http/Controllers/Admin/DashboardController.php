<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today('Asia/Makassar');
        $startOfMonth = $today->copy()->startOfMonth();
        $startOfLastMonth = $today->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $today->copy()->subMonth()->endOfMonth();

        // Statistics
        $kunjunganHariIni = Kunjungan::whereDate('created_at', $today)->count();
        $kunjunganBulanIni = Kunjungan::whereBetween('created_at', [$startOfMonth, $today->copy()->endOfDay()])->count();
        $kunjunganBulanLalu = Kunjungan::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        if ($kunjunganBulanLalu > 0) {
            $trendBulanIni = round((($kunjunganBulanIni - $kunjunganBulanLalu) / $kunjunganBulanLalu) * 100);
            $trendDirection = $trendBulanIni >= 0 ? 'naik' : 'turun';
        } elseif ($kunjunganBulanIni > 0) {
            $trendBulanIni = 100;
            $trendDirection = 'naik';
        } else {
            $trendBulanIni = 0;
            $trendDirection = 'stabil';
        }

        $menungguDiproses = Kunjungan::whereIn('status', ['baru', 'diterima'])->count();
        $akunAktif = User::where('aktif', true)->count();

        // Recent kunjungan (5 latest)
        $kunjunganTerbaru = Kunjungan::with('bidangTujuan:id,nama')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Recent activity (5 latest)
        $aktivitasTerakhir = ActivityLog::with('user:id,name')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'kunjunganHariIni',
            'kunjunganBulanIni',
            'trendBulanIni',
            'trendDirection',
            'menungguDiproses',
            'akunAktif',
            'kunjunganTerbaru',
            'aktivitasTerakhir'
        ));
    }
}