<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\JobController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN HOME (Diubah ke JobController)
Route::get('/', [JobController::class, 'index'])->name('index');

// 2. HALAMAN JOBLIST
Route::get('/joblist', [JobController::class, 'show'])->name('jobs.index');

// 3. FORM APPLY (GET & POST)
Route::get('/applyform', function () {
    return view('user.applyform');
})->name('apply.form');

Route::post('/apply-submit', [MagangController::class, 'store'])->name('apply.submit');