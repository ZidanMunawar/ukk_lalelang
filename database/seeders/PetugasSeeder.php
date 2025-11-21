<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    // Seeder untuk mengisi data petugas dan administrator sistem
    public function run(): void
    {
        DB::table('tb_petugas')->insert([
            [
                'nama_petugas' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'id_level' => 1, // Level administrator
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_petugas' => 'Petugas Satu',
                'username' => 'petugas1',
                'password' => Hash::make('petugas123'),
                'id_level' => 2, // Level petugas
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_petugas' => 'Petugas Dua',
                'username' => 'petugas2',
                'password' => Hash::make('petugas123'),
                'id_level' => 2, // Level petugas
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
