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
        Schema::create('laporan_permintaan', function (Blueprint $table) {
            $table->string('id_laporan', 30)->primary();
            $table->enum('periode_laporan', ['harian', 'mingguan', 'bulanan', 'tahunan']);
            $table->enum('jenis_laporan', ['software', 'hardware']);
            $table->date('tanggal_awal')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->enum('status_laporan', ['belum divalidasi', 'sudah divalidasi'])->nullable();
            $table->string('nip_admin', 5);
            $table->foreign('nip_admin')->references('nip')->on('pegawai')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('ttd_admin', 100)->nullable();

            $table->string('nip_manager', 5)->nullable();
            $table->foreign('nip_manager')->references('nip')->on('pegawai')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('ttd_manager', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_permintaan');
    }
};
