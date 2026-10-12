<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bidangs')->insert([
            [
                'nama' => 'Sekretariat',
                'kode' => 'SET',
                'keterangan' => 'Bidang Sekretariat',
                'aktif' => true,
            ],
            [
                'nama' => 'Akuntansi dan Pelaporan',
                'kode' => 'AKL',
                'keterangan' => 'Bidang Akuntansi dan Pelaporan',
                'aktif' => true,
            ],
            [
                'nama' => 'Perbendaharaan',
                'kode' => 'PER',
                'keterangan' => 'Bidang Perbendaharaan',
                'aktif' => true,
            ],
            [
                'nama' => 'Anggaran',
                'kode' => 'ANG',
                'keterangan' => 'Bidang Anggaran',
                'aktif' => true,
            ],
            [
                'nama' => 'Pengelolaan BMD',
                'kode' => 'BMD',
                'keterangan' => 'Bidang Pengelolaan Barang Milik Daerah',
                'aktif' => true,
            ],
        ]);
    }
}
