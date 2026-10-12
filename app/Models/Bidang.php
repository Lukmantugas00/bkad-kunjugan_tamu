<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bidang extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'keterangan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Semua kunjungan yang ditujukan ke bidang ini.
     */
    public function kunjungans(): HasMany
    {
        return $this->hasMany(
            Kunjungan::class,
            'bidang_tujuan_id'
        );
    }

    /**
     * Kunjungan yang ditujukan ke bidang ini.
     *
     * Alias dari kunjungans().
     */
    public function kunjunganTujuan(): HasMany
    {
        return $this->hasMany(
            Kunjungan::class,
            'bidang_tujuan_id'
        );
    }

    /**
     * Kunjungan yang sebelumnya berasal dari bidang ini.
     */
    public function kunjunganAsal(): HasMany
    {
        return $this->hasMany(
            Kunjungan::class,
            'bidang_asal_id'
        );
    }
}
