<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_barang', function (Blueprint $table) {

            $table->bigInteger('harga_awal')->change();
        });

        Schema::table('tb_lelang', function (Blueprint $table) {

            $table->bigInteger('harga_akhir')->change();
        });

        Schema::table('history_lelang', function (Blueprint $table) {
            $table->bigInteger('penawaran_harga')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_barang', function (Blueprint $table) {
            $table->integer('harga_awal')->change();
        });

        Schema::table('tb_lelang', function (Blueprint $table) {
            $table->integer('harga_akhir')->change();
        });

        Schema::table('history_lelang', function (Blueprint $table) {
            $table->integer('penawaran_harga')->change();
        });
    }
};
