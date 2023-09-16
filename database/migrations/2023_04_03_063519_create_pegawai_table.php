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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('nip', 5)->primary();
            $table->string('nama', 50);
            $table->string('bagian', 100);
            $table->string('jabatan', 50);
            $table->string('id_stasiun', 3);
            $table->foreign('id_stasiun')->references('id_stasiun')->on('stasiun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
