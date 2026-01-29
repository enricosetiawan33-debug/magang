<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagangApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magang_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lowongan_id');
            $table->foreign('lowongan_id')->references('id')->on('lowongan');

            // Data Pribadi
            $table->string('nama');
            $table->string('nim');
            $table->string('universitas');
            $table->string('program_studi');
            $table->string('email');
            $table->string('no_telepon');

            // Informasi Magang
            $table->string('posisi_dilamar');
            $table->string('departemen');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('durasi_bulan');

            // Dokumen (Menyimpan path/lokasi file)
            $table->string('file_cv');
            $table->string('file_surat_rekomendasi');
            $table->string('file_ktp')->nullable();
            $table->string('file_foto');
            $table->string('file_ktm')->nullable();
            $table->string('link_porto')->nullable();
            
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
        Schema::dropIfExists('magang_applications');
    }
}
