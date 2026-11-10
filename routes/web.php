<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

// Halaman utama langsung diarahkan ke Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Resource route untuk Manajemen Pegawai (index, create, store, show, edit, update, destroy)
Route::resource('pegawai', PegawaiController::class);
