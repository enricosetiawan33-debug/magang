<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JobController extends Controller
{
    /**
     * Menampilkan daftar lowongan pekerjaan yang aktif.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        $lowongans = Lowongan::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->get();
							
        return view('user.joblist', compact('lowongans'));
    }
}