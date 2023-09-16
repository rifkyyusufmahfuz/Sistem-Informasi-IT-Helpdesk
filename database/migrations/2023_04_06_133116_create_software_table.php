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
        Schema::create('software', function (Blueprint $table) {
            $table->increments('id_software');
            $table->string('nama_software', 30);
            $table->string('versi_software', 15)->nullable();
            $table->string('notes', 50)->nullable();
            $table->string('id_permintaan', 30);
            $table->timestamps();

            $table->foreign('id_permintaan')->references('id_permintaan')->on('permintaan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
