<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalorieController;
use Illuminate\Support\Facades\Route;

// Rute utama bisa diakses semua orang
Route::get('/', [CalorieController::class, 'index'])->name('calculator.index');

Route::post('/calculate', [CalorieController::class, 'calculate'])->name('calculator.calculate');

// Rute yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [CalorieController::class, 'dashboard'])->name('dashboard');
    // Rute riwayat
    Route::get('/history', [CalorieController::class, 'history'])->name('calculator.history');
    Route::get('/history/download', [CalorieController::class, 'downloadHistoryPdf'])->name('calculator.download.pdf');

    // Rute profil yang dibuat oleh Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ini adalah rute-rute yang dibuat oleh Laravel Breeze
require __DIR__ . '/auth.php';
