<?php

use App\Http\Controllers\DptSearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DptSearchController::class, 'index'])->name('home');
Route::post('/cek-dpt', [DptSearchController::class, 'search'])
    ->middleware('throttle:search-dpt')
    ->name('dpt.search');
