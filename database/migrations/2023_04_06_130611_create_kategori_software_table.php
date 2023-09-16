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
        Schema::create('kategori_software', function (Blueprint $table) {
            $table->increments('id_kategori');
            $table->boolean('operating_system')->default(false);
            $table->boolean('microsoft_office')->default(false);
            $table->boolean('software_design')->default(false);
            $table->boolean('software_lainnya')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_software');
    }
};
