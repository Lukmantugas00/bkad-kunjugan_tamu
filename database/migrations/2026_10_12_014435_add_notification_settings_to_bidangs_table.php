
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bidangs', function (Blueprint $table) {
            $table->boolean('notifikasi_aktif')->default(true);
            $table->string('notifikasi_jenis_suara', 20)->default('khusus');
            $table->unsignedTinyInteger('notifikasi_volume')->default(100);
            $table->string('notifikasi_suara_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bidangs', function (Blueprint $table) {
            $table->dropColumn([
                'notifikasi_aktif',
                'notifikasi_jenis_suara',
                'notifikasi_volume',
                'notifikasi_suara_path',
            ]);
        });
    }
};
