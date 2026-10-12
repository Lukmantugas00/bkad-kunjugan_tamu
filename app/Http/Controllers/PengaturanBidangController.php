<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengaturanBidangController extends Controller
{
    private function bidangPengguna(Request $request)
    {
        $user = $request->user();

        abort_unless(
            $user && $user->role === 'penerima_bidang' && $user->bidang_id,
            403,
            'Hanya penerima bidang yang dapat mengatur notifikasi bidang.'
        );

        return $user->bidang;
    }

    public function edit(Request $request)
    {
        $bidang = $this->bidangPengguna($request);

        abort_if(! $bidang, 403, 'Bidang pengguna tidak ditemukan.');

        return view('pengaturan-bidang.notifikasi', compact('bidang'));
    }

    public function update(Request $request)
    {
        $bidang = $this->bidangPengguna($request);

        abort_if(! $bidang, 403, 'Bidang pengguna tidak ditemukan.');

        $validated = $request->validate([
            'notifikasi_aktif' => ['required', 'boolean'],
            'notifikasi_jenis_suara' => [
                'required',
                Rule::in(['bawaan', 'khusus', 'senyap']),
            ],
            'notifikasi_volume' => ['required', 'integer', 'min:0', 'max:100'],
            'suara_khusus' => [
                'nullable',
                'file',
                'mimes:mp3,wav,ogg',
                'max:5120',
            ],
            'hapus_suara' => ['nullable', 'boolean'],
        ], [
            'notifikasi_aktif.required' => 'Status notifikasi wajib dipilih.',
            'notifikasi_jenis_suara.in' => 'Jenis suara tidak valid.',
            'notifikasi_volume.max' => 'Volume maksimal 100%.',
            'suara_khusus.mimes' => 'Gunakan file MP3, WAV, atau OGG.',
            'suara_khusus.max' => 'Ukuran file suara maksimal 5 MB.',
        ]);

        $jenis = $validated['notifikasi_jenis_suara'];

        if (
            $jenis === 'khusus'
            && ! $request->hasFile('suara_khusus')
            && ! $bidang->notifikasi_suara_path
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'suara_khusus' => 'Unggah file suara khusus terlebih dahulu.',
                ]);
        }

        if ($request->boolean('hapus_suara')) {
            if ($bidang->notifikasi_suara_path) {
                Storage::disk('public')->delete(
                    $bidang->notifikasi_suara_path
                );
            }

            $bidang->notifikasi_suara_path = null;
        }

        if ($request->hasFile('suara_khusus')) {
            if ($bidang->notifikasi_suara_path) {
                Storage::disk('public')->delete(
                    $bidang->notifikasi_suara_path
                );
            }

            $bidang->notifikasi_suara_path = $request
                ->file('suara_khusus')
                ->store('suara-notifikasi', 'public');
        }

        if (
            $jenis === 'khusus'
            && ! $bidang->notifikasi_suara_path
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'suara_khusus' => 'File suara khusus belum tersedia.',
                ]);
        }

        $bidang->notifikasi_aktif =
            (bool) $validated['notifikasi_aktif'];

        $bidang->notifikasi_jenis_suara = $jenis;
        $bidang->notifikasi_volume = (int) $validated['notifikasi_volume'];

        $bidang->save();

        return redirect()
            ->route('pengaturan-bidang.notifikasi')
            ->with('success', 'Pengaturan notifikasi berhasil disimpan.');
    }
}
