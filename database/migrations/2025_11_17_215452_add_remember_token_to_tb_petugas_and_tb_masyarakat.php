<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Menambahkan kolom remember_token untuk fitur remember me pada login
    public function up(): void
    {
        // Tambah remember_token ke tabel petugas
        Schema::table('tb_petugas', function (Blueprint $table) {
            $table->rememberToken()->after('password');
        });

        // Tambah remember_token ke tabel masyarakat
        Schema::table('tb_masyarakat', function (Blueprint $table) {
            $table->rememberToken()->after('password');
        });
    }

    // Menghapus kolom remember_token
    public function down(): void
    {
        Schema::table('tb_petugas', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });

        Schema::table('tb_masyarakat', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
};
