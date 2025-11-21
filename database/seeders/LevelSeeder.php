<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    // Seeder untuk mengisi data level akses pengguna
    public function run(): void
    {
        DB::table('tb_level')->insert([
            [
                'level' => 'administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'level' => 'petugas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
