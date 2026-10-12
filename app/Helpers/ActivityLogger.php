<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(
        string $aktivitas,
        ?string $keterangan = null
    ): void {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'aktivitas' => $aktivitas,
            'keterangan' => $keterangan,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
