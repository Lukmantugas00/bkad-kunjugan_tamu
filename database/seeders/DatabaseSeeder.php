<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'nip' => '1',
            'name' => 'Administrator',
            'role' => 'admin',
            'bidang_id' => null,
            'password' => '1',
            'aktif' => true,
        ]);
    }
}
