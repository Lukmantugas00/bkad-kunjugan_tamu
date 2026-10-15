<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{
    /**
     * Daftar data kunjungan untuk Admin.
     */
    public function index(Request $request)
    {
        $query = Kunjungan::with('bidangTujuan');

        if ($request->filled('q')) {
            $q = trim($request->q);

            $query->where(function ($subQuery) use ($q) {
                $subQuery
                    ->where('nama_pengunjung', 'like', "%{$q}%")
                    ->orWhere('nip', 'like', "%{$q}%")
                    ->orWhere('instansi', 'like', "%{$q}%");
            });
        }

        if ($request->filled('bidang_id')) {
            $query->where(
                'bidang_tujuan_id',
                $request->bidang_id
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
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

        $kunjungans = $query
            ->orderByDesc('created_at')
            ->paginate(15)
            ->onEachSide(1)
            ->withQueryString();

        $bidangs = Bidang::orderBy('nama')->get();

        return view(
            'admin.kunjungan.index',
            compact(
                'kunjungans',
                'bidangs'
            )
        );
    }

    /**
     * Detail data kunjungan Admin.
     */
    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load('bidangTujuan');

        return view(
            'admin.kunjungan.show',
            compact('kunjungan')
        );
    }

    /**
     * Form edit data kunjungan.
     */
    public function edit(Kunjungan $kunjungan)
    {
        $kunjungan->load('bidangTujuan');

        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        return view(
            'admin.kunjungan.edit',
            compact(
                'kunjungan',
                'bidangs'
            )
        );
    }

    /**
     * Memperbarui data kunjungan.
     */
    public function update(
        Request $request,
        Kunjungan $kunjungan
    ) {
        $validated = $request->validate([
            'nama_pengunjung' => [
                'required',
                'string',
                'max:255',
            ],

            'nip' => [
                'required',
                'string',
                'size:18',
            ],

            'jabatan' => [
                'required',
                'string',
                'max:255',
            ],

            'instansi' => [
                'required',
                'string',
                'max:255',
            ],

            'bidang_tujuan_id' => [
                'required',
                'exists:bidangs,id',
            ],

            'keperluan' => [
                'required',
                'string',
            ],

            'tanda_tangan' => [
                'nullable',
                'string',
            ],
        ]);

        $kunjungan->update($validated);

        ActivityLogger::log(
            'Ubah Data Kunjungan',
            'Admin mengubah data kunjungan atas nama '.
            $kunjungan->nama_pengunjung.
            ' dengan ID kunjungan #'.
            $kunjungan->id.
            '.'
        );

        return redirect()
            ->route(
                'admin.kunjungan.show',
                $kunjungan
            )
            ->with(
                'success',
                'Data kunjungan berhasil diperbarui.'
            );
    }
}
