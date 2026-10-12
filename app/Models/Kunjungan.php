<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kunjungan extends Model
{
    protected $fillable = [
        'nama_pengunjung',
        'nip',
        'jabatan',
        'instansi',
        'bidang_tujuan_id',
        'keperluan',
        'status',
        'jawaban_bidang',
        'bidang_asal_id',
        'catatan_pengalihan',
        'tanda_tangan',
        'diterima_at',
        'selesai_at',
    ];

    protected $casts = [
        'diterima_at' => 'datetime',
        'selesai_at' => 'datetime',
    ];

    /**
     * Bidang yang menjadi tujuan kunjungan.
     */
    public function bidangTujuan(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'bidang_tujuan_id');
    }

    /**
     * Bidang asal sebelum kunjungan dialihkan.
     */
    public function bidangAsal(): BelongsTo
    {
        return $this->belongsTo(Bidang::class, 'bidang_asal_id');
    }
}
