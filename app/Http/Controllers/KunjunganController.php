<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KunjunganController extends Controller
{
    private const TZ_TAMPIL = 'Asia/Makassar';

    /**
     * Rentang waktu "hari ini" menurut WITA, dikonversi ke zona
     * yang dipakai aplikasi/database (config app.timezone) agar
     * query tidak bergeser 8 jam.
     */
    private function rentangHariIni(): array
    {
        $tzApp = config('app.timezone');

        return [
            now(self::TZ_TAMPIL)->startOfDay()->setTimezone($tzApp),
            now(self::TZ_TAMPIL)->endOfDay()->setTimezone($tzApp),
        ];
    }

    /**
     * Form kunjungan petugas piket.
     */
    public function create()
    {
        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        $kunjungansHariIni = Kunjungan::with('bidangTujuan')
            ->whereBetween('created_at', $this->rentangHariIni())
            ->orderByDesc('created_at')
            ->get();

        return view(
            'kunjungan.create',
            compact('bidangs', 'kunjungansHariIni')
        );
    }

    /**
     * Status kunjungan hari ini.
     */
    public function statusHariIni()
    {
        try {
            $kunjungans = Kunjungan::with('bidangTujuan')
                ->whereBetween('created_at', $this->rentangHariIni())
                ->orderByDesc('created_at')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $kunjungans->map(function ($kunjungan) {
                    return [
                        'id' => $kunjungan->id,

                        'waktu' => $kunjungan->created_at
                            ? $kunjungan->created_at
                                ->timezone(self::TZ_TAMPIL)
                                ->format('H:i')
                            : '-',

                        'nama' => $kunjungan->nama_pengunjung,

                        'bidang' => $kunjungan->bidangTujuan?->nama
                            ?? '-',

                        'keperluan' => $kunjungan->keperluan,

                        'status' => $kunjungan->status,

                        'diterima_at' => $kunjungan->diterima_at
                            ? $kunjungan->diterima_at
                                ->timezone(self::TZ_TAMPIL)
                                ->format('H:i:s')
                            : null,

                        'selesai_at' => $kunjungan->selesai_at
                            ? $kunjungan->selesai_at
                                ->timezone(self::TZ_TAMPIL)
                                ->format('H:i:s')
                            : null,
                    ];
                })->values(),
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil status kunjungan.',
                'error' => config('app.debug')
                    ? $e->getMessage()
                    : null,
            ], 500);
        }
    }

    /**
     * Menyimpan kunjungan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengunjung' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'size:18'],
            'jabatan' => ['required', 'string', 'max:255'],
            'instansi' => ['required', 'string', 'max:255'],
            'bidang_tujuan_id' => ['required', 'exists:bidangs,id'],
            'keperluan' => ['required', 'string'],
            'tanda_tangan' => ['nullable', 'string'],
        ]);

        $kunjungan = Kunjungan::create($validated);

        ActivityLogger::log(
            'Tambah Kunjungan',
            'Petugas mendaftarkan kunjungan atas nama '.
            $kunjungan->nama_pengunjung.
            ' dengan ID kunjungan #'.
            $kunjungan->id.
            '.'
        );

        return redirect()
            ->route('kunjungan.create')
            ->with('success', 'Kunjungan berhasil didaftarkan.');
    }

    /**
     * Memeriksa akses penerima bidang.
     */
    private function checkBidangAccess(Kunjungan $kunjungan): void
    {
        $user = auth()->user();

        if (
            $user &&
            $user->role === 'penerima_bidang' &&
            (int) $user->bidang_id !==
                (int) $kunjungan->bidang_tujuan_id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke kunjungan ini.'
            );
        }
    }

    /**
     * Detail kunjungan.
     */
    public function show(Kunjungan $kunjungan)
    {
        $this->checkBidangAccess($kunjungan);

        $kunjungan->load('bidangTujuan');

        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        return view(
            'kunjungan.show',
            compact('kunjungan', 'bidangs')
        );
    }

    /**
     * Kotak masuk bidang.
     */
    public function inbox(string $kode)
    {
        $bidang = Bidang::where('kode', strtoupper($kode))
            ->where('aktif', true)
            ->firstOrFail();

        $user = auth()->user();

        if (
            $user &&
            $user->role === 'penerima_bidang' &&
            (int) $user->bidang_id !== (int) $bidang->id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke kotak masuk bidang ini.'
            );
        }

        $kunjungans = Kunjungan::with('bidangTujuan')
            ->where('bidang_tujuan_id', $bidang->id)
            ->orderByRaw(
                "FIELD(status, 'baru', 'diterima', 'selesai')"
            )
            ->orderByDesc('created_at')
            ->get();

        return view(
            'kunjungan.inbox',
            compact('bidang', 'kunjungans')
        );
    }

    /**
     * Menerima kunjungan.
     */
    public function terima(Kunjungan $kunjungan)
    {
        $this->checkBidangAccess($kunjungan);

        $kunjungan->update([
            'status' => 'diterima',
            'diterima_at' => now(),
        ]);

        ActivityLogger::log(
            'Terima Kunjungan',
            'Penerima bidang menerima kunjungan atas nama '.
            $kunjungan->nama_pengunjung.
            ' dengan ID kunjungan #'.
            $kunjungan->id.
            '.'
        );

        return redirect()
            ->route('kunjungan.show', $kunjungan)
            ->with('success', 'Kunjungan berhasil diterima.');
    }

    /**
     * Menyelesaikan kunjungan.
     */
    public function selesai(Request $request, Kunjungan $kunjungan)
    {
        $this->checkBidangAccess($kunjungan);

        $validated = $request->validate([
            'jawaban_bidang' => ['required', 'string'],
        ]);

        $kunjungan->update([
            'status' => 'selesai',
            'jawaban_bidang' => $validated['jawaban_bidang'],
            'selesai_at' => now(),
        ]);

        ActivityLogger::log(
            'Selesaikan Kunjungan',
            'Penerima bidang menyelesaikan kunjungan atas nama '.
            $kunjungan->nama_pengunjung.
            ' dengan ID kunjungan #'.
            $kunjungan->id.
            '.'
        );

        return redirect()
            ->route('kunjungan.show', $kunjungan)
            ->with('success', 'Kunjungan berhasil diselesaikan.');
    }

    /**
     * Mengalihkan kunjungan ke bidang lain.
     *
     * Petugas piket dan penerima bidang dapat mengalihkan
     * kunjungan sesuai kewenangannya.
     */
    public function alihkan(Request $request, Kunjungan $kunjungan)
    {
        $user = $request->user();

        // Hanya role yang diizinkan yang dapat mengalihkan.
        if (! in_array($user->role, [
            'petugas_piket',
            'penerima_bidang',
        ], true)) {
            abort(403, 'Anda tidak memiliki izin untuk mengalihkan kunjungan.');
        }

        // Penerima bidang hanya boleh mengalihkan kunjungan bidangnya sendiri.
        if ($user->role === 'penerima_bidang') {
            $this->checkBidangAccess($kunjungan);
        }

        $validated = $request->validate([
            'bidang_tujuan_id' => ['required', 'integer', 'exists:bidangs,id'],
            'catatan_pengalihan' => ['nullable', 'string', 'max:1000'],
        ]);

        // Ambil bidang tujuan yang masih aktif.
        $bidangBaru = Bidang::where('aktif', true)
            ->find($validated['bidang_tujuan_id']);

        if (! $bidangBaru) {
            return back()
                ->withErrors([
                    'bidang_tujuan_id' => 'Bidang tujuan tidak aktif atau tidak ditemukan.',
                ])
                ->withInput();
        }

        // Tidak boleh mengalihkan ke bidang yang sama.
        if ((int) $bidangBaru->id === (int) $kunjungan->bidang_tujuan_id) {
            return back()
                ->withErrors([
                    'bidang_tujuan_id' => 'Pilih bidang tujuan yang berbeda.',
                ])
                ->withInput();
        }

        DB::transaction(function () use ($kunjungan, $validated, $bidangBaru) {
            $kunjungan->bidang_tujuan_id = $bidangBaru->id;
            $kunjungan->status = 'baru';
            $kunjungan->diterima_at = null;
            $kunjungan->selesai_at = null;

            if (Schema::hasColumn('kunjungans', 'catatan_pengalihan')) {
                $kunjungan->catatan_pengalihan =
                    $validated['catatan_pengalihan'] ?? null;
            }

            $kunjungan->save();
        });

        ActivityLogger::log(
            'Alihkan Kunjungan',
            'Kunjungan atas nama '.
            $kunjungan->nama_pengunjung.
            ' dialihkan ke bidang '.
            $bidangBaru->nama.
            ' dengan ID kunjungan #'.
            $kunjungan->id.
            '.'
        );

        $pesan = 'Kunjungan berhasil dialihkan ke bidang '.
            $bidangBaru->nama.'.';

        // Setelah dialihkan, kunjungan sudah milik bidang baru. Penerima
        // bidang asal tidak boleh dikembalikan (back()) ke halaman detail
        // karena akan ditolak oleh checkBidangAccess() dengan 403.
        if ($user->role === 'penerima_bidang') {
            $bidangAsal = Bidang::find($user->bidang_id);

            if ($bidangAsal) {
                return redirect()
                    ->route('kunjungan.inbox', $bidangAsal->kode)
                    ->with('success', $pesan);
            }

            return redirect('/')->with('success', $pesan);
        }

        // Petugas piket kembali ke form/daftar kunjungan hari ini.
        return redirect()
            ->route('kunjungan.create')
            ->with('success', $pesan);
    }

    /**
     * Mengambil jumlah dan daftar notifikasi kunjungan baru.
     */
    public function jumlahNotifikasiBaru(Request $request)
    {
        $user = $request->user();

        if (! $user || ! $user->bidang_id) {
            return response()
                ->json([
                    'count' => 0,
                    'items' => [],
                ], 403)
                ->header('Cache-Control', 'no-store, private');
        }

        $query = Kunjungan::query()
            ->where('bidang_tujuan_id', $user->bidang_id)
            ->whereIn('status', ['baru', 'menunggu']);

        $count = (clone $query)->count();

        $items = (clone $query)
            ->latest('created_at')
            ->latest('id')
            ->limit(5)
            ->get([
                'id',
                'nama_pengunjung',
                'instansi',
                'created_at',
            ])
            ->map(function ($kunjungan) {
                return [
                    'id' => $kunjungan->id,
                    'nama' => $kunjungan->nama_pengunjung,
                    'instansi' => $kunjungan->instansi,
                    'url' => route('kunjungan.show', $kunjungan->id),
                ];
            })
            ->values();

        return response()
            ->json([
                'count' => $count,
                'items' => $items,
            ])
            ->header('Cache-Control', 'no-store, private');

    }
}
