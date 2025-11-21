<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    // Membuat tabel barang untuk menyimpan data barang lelang
    public function up(): void
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id('id_barang');

            // Nama barang yang dilelang
            $table->string('nama_barang', 50);

            // Tanggal barang didaftarkan
            $table->date('tgl');

            // Harga awal lelang
            $table->integer('harga_awal');

            // Deskripsi detail barang
            $table->text('deskripsi_barang');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_barang');
    }
};
