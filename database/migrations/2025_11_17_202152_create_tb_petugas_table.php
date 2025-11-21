<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    // Membuat tabel petugas untuk menyimpan data petugas sistem
    public function up(): void
    {
        Schema::create('tb_petugas', function (Blueprint $table) {
            $table->id('id_petugas');

            // Nama lengkap petugas
            $table->string('nama_petugas', 25);

            // Username untuk login
            $table->string('username', 25)->unique();

            // Password terenkripsi
            $table->string('password', 255);

            // Relasi ke tabel level
            $table->unsignedBigInteger('id_level');
            $table->foreign('id_level')->references('id_level')->on('tb_level')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_petugas');
    }
};
