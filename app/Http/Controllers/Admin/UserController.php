<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar akun.
     */
    public function index()
    {
        $users = User::with('bidang')
            ->orderBy('name')
            ->get();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    /**
     * Form tambah akun.
     */
    public function create()
    {
        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        return view(
            'admin.users.create',
            compact('bidangs')
        );
    }

    /**
     * Menyimpan akun baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:18',
                'unique:users,nip',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'petugas_piket',
                    'penerima_bidang',
                    'pimpinan',
                ]),
            ],

            'bidang_id' => [
                'nullable',
                'exists:bidangs,id',
                'required_if:role,penerima_bidang',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'aktif' => [
                'required',
                'boolean',
            ],
        ]);

        /*
         * Hanya Penerima Bidang yang memiliki bidang.
         */
        if ($validated['role'] !== 'penerima_bidang') {
            $validated['bidang_id'] = null;
        }

        /*
         * Simpan akun baru.
         */
        $user = User::create($validated);

        /*
         * Catat aktivitas Admin.
         */
        ActivityLogger::log(
            'Tambah Akun',
            'Admin menambahkan akun '.
            $user->name.
            ' dengan NIP '.
            $user->nip.
            ' dan role '.
            $user->role.
            '.'
        );

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Akun berhasil ditambahkan.'
            );
    }

    /**
     * Form edit akun.
     */
    public function edit(User $user)
    {
        $bidangs = Bidang::where('aktif', true)
            ->orderBy('nama')
            ->get();

        return view(
            'admin.users.edit',
            compact('user', 'bidangs')
        );
    }

    /**
     * Memperbarui akun.
     */
    public function update(
        Request $request,
        User $user
    ) {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:18',
                Rule::unique('users', 'nip')
                    ->ignore($user->id),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'petugas_piket',
                    'penerima_bidang',
                    'pimpinan',
                ]),
            ],

            'bidang_id' => [
                'nullable',
                'exists:bidangs,id',
                'required_if:role,penerima_bidang',
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed',
            ],

            'aktif' => [
                'required',
                'boolean',
            ],
        ]);

        /*
         * Selain Penerima Bidang,
         * bidang harus dikosongkan.
         */
        if ($validated['role'] !== 'penerima_bidang') {
            $validated['bidang_id'] = null;
        }

        /*
         * Jika password kosong,
         * password lama tetap digunakan.
         */
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        /*
         * Catat aktivitas Admin.
         */
        ActivityLogger::log(
            'Ubah Akun',
            'Admin mengubah akun '.
            $user->name.
            ' dengan NIP '.
            $user->nip.
            '.'
        );

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'Akun berhasil diperbarui.'
            );
    }

    /**
     * Mengaktifkan / menonaktifkan akun.
     */
    public function toggleAktif(User $user)
    {
        /*
         * Jangan sampai Admin menonaktifkan
         * akun yang sedang digunakan sendiri.
         */
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Akun yang sedang digunakan tidak dapat dinonaktifkan.'
                );
        }

        $user->update([
            'aktif' => ! $user->aktif,
        ]);

        $status = $user->aktif
            ? 'diaktifkan'
            : 'dinonaktifkan';

        /*
         * Catat aktivitas Admin.
         */
        ActivityLogger::log(
            $user->aktif
                ? 'Aktifkan Akun'
                : 'Nonaktifkan Akun',
            'Admin mengubah status akun '.
            $user->name.
            ' menjadi '.
            $status.
            '.'
        );

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                "Akun {$user->name} berhasil {$status}."
            );
    }
}
