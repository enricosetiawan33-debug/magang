<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagangApplication extends Model
{
    use HasFactory;

    protected $table = 'magang_applications';

    //nama field di database
    protected $fillable = [
        'lowongan_id', 'nama', 'nim', 'universitas', 'program_studi', 'email', 'no_telepon',
        'posisi_dilamar', 'departemen', 'tanggal_mulai', 'tanggal_selesai', 'durasi_bulan',
        'file_cv', 'file_surat_rekomendasi', 'file_foto', 'file_ktm', 'file_ktp', 'link_porto'
    ]; 
}
