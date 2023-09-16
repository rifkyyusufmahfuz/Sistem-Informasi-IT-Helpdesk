<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_barang', 20)->primary();
            $table->string('nama_barang', 50)->nullable();
            $table->string('prosesor', 25)->nullable();
            $table->string('ram', 10)->nullable();
            $table->string('penyimpanan', 10)->nullable();

            $table->integer('jumlah_barang');
            $table->enum('status_barang', ['belum diterima', 'diterima', 'siap diambil', 'dikembalikan']);
            // 1 = belum diterima
            // 2 = diterima
            // 3 = dikembalikan


            // $table->unsignedInteger('id_permintaan');
            $table->timestamps();

            // $table->foreign('id_permintaan')
            //     ->references('id_permintaan')
            //     ->on('permintaan')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
