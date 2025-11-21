<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // Membuat tabel gambar barang untuk menyimpan gambar terkait barang lelang
    public function up()
    {
        Schema::create('tb_gambar_barang', function (Blueprint $table) {
            $table->id('id_gambar');

            // Relasi ke tabel barang
            $table->unsignedBigInteger('id_barang');

            // Nama file atau path gambar
            $table->string('gambar', 255);

            // Menandai apakah gambar ini adalah gambar utama
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('tb_barang')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_gambar_barang');
    }
};
