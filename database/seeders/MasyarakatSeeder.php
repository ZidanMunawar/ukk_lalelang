<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MasyarakatSeeder extends Seeder
{
    // Seeder untuk mengisi data masyarakat pengguna sistem lelang
    public function run(): void
    {
        DB::table('tb_masyarakat')->insert([
            [
                'nama_lengkap' => 'Budi Santoso',
                'nik' => '3201012001900001',
                'password' => Hash::make('password123'),
                'telp' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 123, RT 01/RW 05, Kelurahan Sukamaju, Kecamatan Bandung Selatan, Kota Bandung, Jawa Barat 40132',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Siti Aminah',
                'nik' => '3201012001900002',
                'password' => Hash::make('password123'),
                'telp' => '081234567891',
                'alamat' => 'Jl. Gatot Subroto No. 45, RT 02/RW 03, Kelurahan Cihapit, Kecamatan Bandung Wetan, Kota Bandung, Jawa Barat 40114',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Ahmad Fauzi',
                'nik' => '3201012001900003',
                'password' => Hash::make('password123'),
                'telp' => '081234567892',
                'alamat' => 'Jl. Asia Afrika No. 78, RT 03/RW 02, Kelurahan Braga, Kecamatan Sumur Bandung, Kota Bandung, Jawa Barat 40111',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Dewi Lestari',
                'nik' => '3201012001900004',
                'password' => Hash::make('password123'),
                'telp' => '081234567893',
                'alamat' => 'Jl. Dago No. 12, RT 04/RW 01, Kelurahan Dago, Kecamatan Coblong, Kota Bandung, Jawa Barat 40135',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lengkap' => 'Eko Prasetyo',
                'nik' => '3201012001900005',
                'password' => Hash::make('password123'),
                'telp' => '081234567894',
                'alamat' => 'Jl. Cihampelas No. 88, RT 05/RW 04, Kelurahan Cipaganti, Kecamatan Coblong, Kota Bandung, Jawa Barat 40131',
                'status' => 'nonaktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
