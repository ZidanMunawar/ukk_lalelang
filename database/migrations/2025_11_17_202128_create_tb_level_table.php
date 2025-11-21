<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    // Membuat tabel level untuk manajemen role pengguna
    public function up(): void
    {
        Schema::create('tb_level', function (Blueprint $table) {
            $table->id('id_level');

            // Tipe level: administrator atau petugas
            $table->enum('level', ['administrator', 'petugas']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_level');
    }
};
