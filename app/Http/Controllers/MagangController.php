<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MagangApplication;
use App\Models\Lowongan; // Pastikan import ini ada
use Carbon\Carbon;       // Pastikan import ini ada
use Illuminate\Support\Facades\Storage;

class MagangController extends Controller
{
    // TAMBAHKAN FUNCTION INI UNTUK MENAMPILKAN FORM
    // Function ini yang mengatasi error "Undefined variable $lowongan"
    public function showApplyForm()
    {
        return view('user.applyform');
    }

    // FUNCTION UNTUK PROSES DATA (YANG ANDA KIRIM)
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'lowongan_id' => 'required|exists:lowongan,id', // Wajib ada
            'nama' => 'required|string|max:100',
            'nim' => 'required|numeric|digits_between:8,15',
            'univ' => 'required|string',
            'jurusan' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|numeric|digits_between:10,15',
            // Kita tidak butuh validasi posisi/departemen string manual lagi 
            // karena akan diambil otomatis dari lowongan_id, tapi jika form Anda masih mengirimnya, biarkan saja.
            'posisi' => 'required|string',
            'departemen' => 'required|string',
            'mulai' => 'required|date',
            'selesai' => 'required|date',
            'durasi' => 'required|integer|min:3|max:12',
            
            // Validasi File
            'cv' => 'required|mimes:pdf|max:2048',
            'surat' => 'required|mimes:pdf|max:2048',
            'transkrip' => 'required|mimes:pdf|max:2048',
            'ktp' => 'required|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'required|mimes:jpg,jpeg,png|max:2048',
            'ktm' => 'required|mimes:jpg,jpeg,png|max:2048',
            'link' => 'nullable|string',
        ]);

        // 2. LOGIKA UTAMA: CEK LOWONGAN & DEADLINE (PINDAH KE ATAS)
        // Kita cek dulu sebelum upload file agar tidak membebani server jika ditolak
        $lowongan = Lowongan::findOrFail($request->lowongan_id);
        
        $deadline = Carbon::parse($lowongan->deadline)->endOfDay();
        if (Carbon::now()->greaterThan($deadline)) {
            return redirect()->back()
                ->withInput() // Kembalikan input user agar tidak ngetik ulang
                ->withErrors(['msg' => 'Maaf, pendaftaran untuk posisi ini sudah ditutup (Deadline terlewati).']);
        }

        // 3. Proses Upload File (Hanya jika deadline aman)
        $cvPath = $request->file('cv')->store('uploads/cv', 'public');
        $suratPath = $request->file('surat')->store('uploads/surat', 'public');
        $ktpPath = $request->file('ktp')->store('uploads/ktp', 'public');
        $fotoPath = $request->file('foto')->store('uploads/foto', 'public');
        $ktmPath = $request->file('ktm')->store('uploads/ktm', 'public');
        $transkripPath = $request->file('transkrip')->store('uploads/transkrip', 'public');

        // 4. Simpan ke Database
        MagangApplication::create([
            'lowongan_id' => $lowongan->id, // Ambil dari variable lowongan yang sudah dicari di atas
            'nama' => $request->nama,
            'status' => 'pending', // Set default
            'nim' => $request->nim,
            'universitas' => $request->univ,
            'program_studi' => $request->jurusan,
            'email' => $request->email,
            'no_telepon' => $request->telepon,
            
            // Gunakan data dari Tabel Lowongan agar konsisten (lebih aman)
            // Tapi jika ingin pakai inputan user: $request->posisi
            'posisi_dilamar' => $lowongan->title, 
            'departemen' => $lowongan->division, 
            
            'tanggal_mulai' => $request->mulai,
            'tanggal_selesai' => $request->selesai,
            'durasi_bulan' => $request->durasi,
            'file_cv' => $cvPath,
            'file_surat_rekomendasi' => $suratPath,
            'file_transkrip' => $transkripPath,
            'file_ktp' => $ktpPath,
            'file_foto' => $fotoPath,
            'file_ktm' => $ktmPath,
            'link_porto' => $request->link,
        ]);

        // 5. Redirect Sukses
        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }
}