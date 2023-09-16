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
        Schema::create('otorisasi', function (Blueprint $table) {
            $table->increments('id_otorisasi');
            $table->date('tanggal_approval')->nullable();
            $table->enum('status_approval', ['pending', 'waiting', 'approved', 'rejected', 'revision']);
            $table->string('catatan', 100);
            $table->string('ttd_manager', 100)->nullable();

            $table->unsignedInteger('id')->nullable();
            $table->foreign('id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otorisasi');
    }
};
