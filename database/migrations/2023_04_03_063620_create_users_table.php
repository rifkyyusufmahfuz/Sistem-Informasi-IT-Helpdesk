<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 50);
            $table->string('password', 60);
            $table->boolean('status')->default(false); // tambahkan kolom status

            //relasi
            $table->integer('id_role')->unsigned();
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->string('nip', 5);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');

            //timestamp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
