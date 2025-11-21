<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    // Membuat tabel lelang untuk menyimpan data lelang barang
    public function up()
    {
        Schema::create('tb_lelang', function (Blueprint $table) {
            $table->id('id_lelang');

            // Relasi ke tabel barang
            $table->unsignedBigInteger('id_barang');

            // Tanggal pelaksanaan lelang
            $table->date('tgl_lelang');

            // Harga akhir dari lelang
            $table->integer('harga_akhir');

            // Relasi ke tabel masyarakat (user)
            $table->unsignedBigInteger('id_user')->nullable();

            // Relasi ke tabel petugas
            $table->unsignedBigInteger('id_petugas');

            // Status lelang: dibuka atau ditutup
            $table->enum('status', ['dibuka', 'ditutup'])->default('ditutup');
            $table->timestamps();

            // Definisi foreign key
            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('tb_barang')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Definisi foreign key
            $table->foreign('id_user')
                ->references('id_user')
                ->on('tb_masyarakat')
                ->onDelete('set null')
                ->onUpdate('cascade');


            // Definisi foreign key
            $table->foreign('id_petugas')
                ->references('id_petugas')
                ->on('tb_petugas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lelang');
    }
};
