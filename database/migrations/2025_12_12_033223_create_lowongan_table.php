<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowonganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul
            $table->string('division'); // Divisi
            $table->string('level'); // Tingkat Pendidikan
            $table->integer('quota'); // Kuota
            $table->date('deadline'); // Batas Pendaftaran
            $table->text('description'); // Deskripsi
            $table->text('requirements'); // Persyaratan
            $table->boolean('is_active')->default(true); // Status (Aktif/Tutup)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lowongan');
    }
}
