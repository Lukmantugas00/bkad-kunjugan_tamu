<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BidangController extends Controller
{
    /**
     * Menampilkan daftar bidang.
     */
    public function index()
    {
        $bidangs = Bidang::orderBy('nama')->get();

        return view(
            'admin.bidangs.index',
            compact('bidangs')
        );
    }

    /**
     * Form tambah bidang.
     */
    public function create()
    {
        return view('admin.bidangs.create');
    }

    /**
     * Menyimpan bidang baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:10',
                'unique:bidangs,kode',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'aktif' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['kode'] = strtoupper(
            trim($validated['kode'])
        );

        /*
         * Simpan bidang baru.
         */
        $bidang = Bidang::create($validated);

        /*
         * Catat aktivitas Admin.
         */
        ActivityLogger::log(
            'Tambah Bidang',
            'Admin menambahkan bidang '.
            $bidang->kode.
            ' - '.
            $bidang->nama.
            '.'
        );

        return redirect()
            ->route('admin.bidangs.index')
            ->with(
                'success',
                'Bidang berhasil ditambahkan.'
            );
    }

    /**
     * Form edit bidang.
     */
    public function edit(Bidang $bidang)
    {
        return view(
            'admin.bidangs.edit',
            compact('bidang')
        );
    }

    /**
     * Memperbarui bidang.
     */
    public function update(
        Request $request,
        Bidang $bidang
    ) {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:10',
                Rule::unique('bidangs', 'kode')
                    ->ignore($bidang->id),
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'aktif' => [
                'required',
                'boolean',
            ],
        ]);

        $validated['kode'] = strtoupper(
            trim($validated['kode'])
        );

        $bidang->update($validated);

        /*
         * Catat aktivitas Admin.
         */
        ActivityLogger::log(
            'Ubah Bidang',
            'Admin mengubah data bidang '.
            $bidang->kode.
            ' - '.
            $bidang->nama.
            '.'
        );

        return redirect()
            ->route('admin.bidangs.index')
            ->with(
                'success',
                'Bidang berhasil diperbarui.'
            );
    }

    /**
     * Mengaktifkan / menonaktifkan bidang.
     */
    public function toggleAktif(Bidang $bidang)
    {
        $bidang->update([
            'aktif' => ! $bidang->aktif,
        ]);

        $status = $bidang->aktif
            ? 'diaktifkan'
            : 'dinonaktifkan';

        /*
         * Catat aktivitas Admin.
         */
        ActivityLogger::log(
            $bidang->aktif
                ? 'Aktifkan Bidang'
                : 'Nonaktifkan Bidang',
            'Admin mengubah status bidang '.
            $bidang->kode.
            ' - '.
            $bidang->nama.
            ' menjadi '.
            $status.
            '.'
        );

        return redirect()
            ->route('admin.bidangs.index')
            ->with(
                'success',
                "Bidang {$bidang->nama} berhasil {$status}."
            );
    }
}
