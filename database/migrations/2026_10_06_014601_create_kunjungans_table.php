<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();

            // Identitas pengunjung
            $table->string('nama_pengunjung');
            $table->string('nip', 18);
            $table->string('jabatan');
            $table->string('instansi');

            // Tujuan kunjungan
            $table->foreignId('bidang_tujuan_id')
                ->constrained('bidangs')
                ->restrictOnDelete();

            $table->text('keperluan');

            // Status kunjungan
            $table->enum('status', [
                'baru',
                'diterima',
                'selesai',
            ])->default('baru');

            // Jawaban dari bidang
            $table->text('jawaban_bidang')->nullable();

            // Pengalihan kunjungan
            $table->foreignId('bidang_asal_id')
                ->nullable()
                ->constrained('bidangs')
                ->nullOnDelete();

            $table->text('catatan_pengalihan')->nullable();

            // Tanda tangan digital pengunjung
            $table->text('tanda_tangan')->nullable();

            // Waktu proses
            $table->timestamp('diterima_at')->nullable();
            $table->timestamp('selesai_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
