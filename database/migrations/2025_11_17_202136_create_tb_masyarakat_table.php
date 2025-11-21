<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    // Membuat tabel masyarakat untuk menyimpan data pengguna masyarakat
    public function up(): void
    {
        Schema::create('tb_masyarakat', function (Blueprint $table) {
            $table->id('id_user');

            // Nama lengkap masyarakat
            $table->string('nama_lengkap', 50);

            // NIK sebagai identitas unik masyarakat
            $table->string('nik', 16)->unique();

            // Password untuk login
            $table->string('password', 255);

            // Nomor telepon
            $table->string('telp', 25);

            // Alamat lengkap masyarakat
            $table->text('alamat');

            // Status akun: aktif atau nonaktif
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_masyarakat');
    }
};
