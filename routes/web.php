<!-- route web.php -->

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\JobController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.index');
})->name('index');

Route::get('/applyform', function () {
    return view('user.applyform');
});

// 1. Route GET: Untuk MENAMPILKAN halaman form
// Hapus parameter /{id}
Route::get('/applyform', [MagangController::class, 'showApplyForm'])->name('magang.applyform');

// 2. Route POST: Untuk MENYIMPAN data 
Route::post('/apply-submit', [MagangController::class, 'store'])->name('apply.submit');

// Route untuk menampilkan daftar lowongan
Route::get('/joblist', [JobController::class, 'show'])->name('jobs.index');

