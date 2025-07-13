<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalorieController;
use App\Http\Controllers\ProfileController;

Route::get('/', [CalorieController::class, 'index'])->name('calculator.index');

// Rute untuk fungsionalitas kalkulator
Route::post('/calculate', [CalorieController::class, 'calculate'])->name('calculator.calculate');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk halaman utama setelah login
    Route::get('/dashboard', [CalorieController::class, 'dashboard'])->name('dashboard');

    // Rute untuk halaman riwayat
    Route::get('/history', [CalorieController::class, 'history'])->name('calculator.history');
    Route::get('/history/download', [CalorieController::class, 'downloadHistoryPdf'])->name('calculator.download.pdf');

    // RUTE UNTUK MENGHAPUS RIWAYAT
    Route::delete('/history/{history}', [CalorieController::class, 'destroyHistory'])->name('history.destroy');
});

require __DIR__ . '/auth.php';
