<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('q')) {
            $q = trim($request->q);

            $query->where(function ($subQuery) use ($q) {
                $subQuery
                    ->where('aktivitas', 'like', "%{$q}%")
                    ->orWhere('keterangan', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery
                            ->where('name', 'like', "%{$q}%")
                            ->orWhere('nip', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('aktivitas')) {
            $query->where('aktivitas', $request->aktivitas);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->tanggal_akhir
            );
        }

        $logs = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->onEachSide(1)
            ->withQueryString();

        $users = User::orderBy('name')->get();

        $aktivitas = ActivityLog::query()
            ->select('aktivitas')
            ->distinct()
            ->orderBy('aktivitas')
            ->pluck('aktivitas');

        return view(
            'admin.activity_logs.index',
            compact(
                'logs',
                'users',
                'aktivitas'
            )
        );
    }

    public function latest(Request $request)
    {
        try {

            $query = ActivityLog::with('user');

            /*
             * Pencarian
             */
            if ($request->filled('q')) {

                $q = trim($request->q);

                $query->where(function ($subQuery) use ($q) {

                    $subQuery
                        ->where(
                            'aktivitas',
                            'like',
                            "%{$q}%"
                        )
                        ->orWhere(
                            'keterangan',
                            'like',
                            "%{$q}%"
                        )
                        ->orWhereHas(
                            'user',
                            function ($userQuery) use ($q) {

                                $userQuery
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$q}%"
                                    )
                                    ->orWhere(
                                        'nip',
                                        'like',
                                        "%{$q}%"
                                    );
                            }
                        );
                });
            }

            /*
             * Filter pengguna
             */
            if ($request->filled('user_id')) {

                $query->where(
                    'user_id',
                    $request->user_id
                );
            }

            /*
             * Filter aktivitas
             */
            if ($request->filled('aktivitas')) {

                $query->where(
                    'aktivitas',
                    $request->aktivitas
                );
            }

            /*
             * Filter tanggal mulai
             */
            if ($request->filled('tanggal_mulai')) {

                $query->whereDate(
                    'created_at',
                    '>=',
                    $request->tanggal_mulai
                );
            }

            /*
             * Filter tanggal akhir
             */
            if ($request->filled('tanggal_akhir')) {

                $query->whereDate(
                    'created_at',
                    '<=',
                    $request->tanggal_akhir
                );
            }

            /*
             * Ambil 20 log terbaru
             */
            $logs = $query
                ->orderByDesc('created_at')
                ->limit(20)
                ->get();

            /*
             * Format JSON
             */
            $data = $logs->map(function ($log) {

                return [

                    'id' => $log->id,

                    'waktu' => $log->created_at
                        ? $log->created_at
                            ->timezone('Asia/Makassar')
                            ->format('d-m-Y H:i:s')
                        : '-',

                    'pengguna' => $log->user?->name
                        ?? 'Sistem',

                    'nip' => $log->user?->nip
                        ?? '-',

                    'role' => $log->user?->role
                        ?? null,

                    'aktivitas' => $log->aktivitas
                        ?? '-',

                    'keterangan' => $log->keterangan
                        ?? '-',

                    'ip_address' => $log->ip_address
                        ?? '-',
                ];
            })->values();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);

        } catch (\Throwable $e) {

            /*
             * Jangan biarkan AJAX mendapat HTML error.
             * Selalu kembalikan JSON.
             */
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil log aktivitas.',

                'error' => config('app.debug')
                        ? $e->getMessage()
                        : null,
            ], 500);
        }
    }
}
