<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Menampilkan Halaman Home dengan 3 Lowongan Terbaru.
     */
    public function index()
    {
        // Ambil 3 lowongan terbaru yang aktif
        $recentJobs = Lowongan::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->take(3) // Batasi hanya 3
                            ->get();

        // Kirim ke view 'user.index' (Halaman Home)
        return view('user.index', compact('recentJobs'));
    }

    /**
     * Menampilkan Halaman Joblist (Semua Lowongan).
     */
    public function show()
    {
        $lowongans = Lowongan::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('user.joblist', compact('lowongans'));
    }
}