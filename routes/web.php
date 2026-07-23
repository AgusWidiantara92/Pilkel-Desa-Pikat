<?php

use App\Http\Controllers\CekDptController;
use Illuminate\Support\Facades\Route;

// ──────────────────────────────────────────────
// ROUTING PUBLIK — Cek DPT untuk Masyarakat
// ──────────────────────────────────────────────

// Halaman utama: Form pencarian DPT
Route::get('/', [CekDptController::class, 'index'])->name('home');

// Proses pencarian: Validasi NIK & tampilkan hasil
Route::post('/cek-dpt', [CekDptController::class, 'search'])
    ->middleware('throttle:search-dpt')
    ->name('dpt.search');
