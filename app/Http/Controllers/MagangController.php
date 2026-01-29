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
        // 1. Validasi Input (Sama seperti sebelumnya)
        $validated = $request->validate([
            'lowongan_id' => 'required|exists:lowongan,id',
            'nama' => 'required|string|max:100',
            'nim' => 'required|numeric|digits_between:8,15',
            'univ' => 'required|string',
            'jurusan' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|numeric|digits_between:10,15',
            'posisi' => 'required|string',
            'departemen' => 'required|string',
            'mulai' => 'required|date',
            'selesai' => 'required|date',
            'durasi' => 'required|integer',
            'cv' => 'required|mimes:pdf|max:2048',
            'surat' => 'required|mimes:pdf|max:2048',
            'foto' => 'required|mimes:jpg,jpeg,png|max:2048',
            'ktm' => 'nullable|mimes:jpg,jpeg,png|max:2048', // Opsional
            'ktp' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048', // Opsional
            'link' => 'nullable|string',
        ]);

        // 2. CEK DEADLINE DULU (Sebelum simpan data/upload)
        $lowongan = \App\Models\Lowongan::find($request->lowongan_id);
        if ($lowongan) {
            $deadline = Carbon::parse($lowongan->deadline)->endOfDay();
            if (Carbon::now()->greaterThan($deadline)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['msg' => 'Maaf, pendaftaran ditutup (Deadline terlewati).']);
            }
        }

        // 3. Proses Upload File (Gunakan Logika "hasFile" untuk yang nullable)
        // Folder public/uploads harus sudah dilink (php artisan storage:link)
        $cvPath = $request->file('cv')->store('uploads/cv', 'public');
        $suratPath = $request->file('surat')->store('uploads/surat', 'public');
        $fotoPath = $request->file('foto')->store('uploads/foto', 'public');
        
        // Penanganan File Opsional (Agar tidak error jika kosong)
        $ktmPath = $request->hasFile('ktm') ? $request->file('ktm')->store('uploads/ktm', 'public') : null;
        $ktpPath = $request->hasFile('ktp') ? $request->file('ktp')->store('uploads/ktp', 'public') : null;

        // 4. Simpan ke Database
        MagangApplication::create([
            'lowongan_id' => $request->lowongan_id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'universitas' => $request->univ,
            'program_studi' => $request->jurusan,
            'email' => $request->email,
            'no_telepon' => $request->telepon,
            'posisi_dilamar' => $request->posisi,
            'departemen' => $request->departemen,
            'tanggal_mulai' => $request->mulai,
            'tanggal_selesai' => $request->selesai,
            'durasi_bulan' => $request->durasi,
            'file_cv' => $cvPath,
            'file_surat_rekomendasi' => $suratPath,
            'file_foto' => $fotoPath,
            'file_ktm' => $ktmPath, // Bisa null
            'file_ktp' => $ktpPath, // Bisa null
            'link_porto' => $request->link, // Bisa null
        ]);

        // 5. Redirect Sukses
        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }
}