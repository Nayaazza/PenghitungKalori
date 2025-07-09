<?php

use App\Http\Controllers\CalorieController;
use Illuminate\Support\Facades\Route;


// Rute utama untuk menampilkan kalkulator
Route::get('/', [CalorieController::class, 'index'])->name('calculator.index');

// Rute untuk memproses perhitungan (via AJAX)
Route::post('/calculate', [CalorieController::class, 'calculate'])->name('calculator.calculate');

// Rute untuk menampilkan halaman riwayat (FR05)
Route::get('/history', [CalorieController::class, 'history'])->name('calculator.history');

// Rute untuk mengunduh riwayat dalam bentuk PDF (FR06)
Route::get('/history/download', [CalorieController::class, 'downloadHistoryPdf'])->name('calculator.download.pdf');
