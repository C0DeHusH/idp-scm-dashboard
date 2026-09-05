<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public/Guest Dashboard View
Route::get('/', [DashboardController::class, 'index'])->name('dashboard.unified');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Protected Admin Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Data Import Controls
    Route::get('/admin/import', [ImportController::class, 'index'])->name('admin.import');
    Route::post('/admin/import', [ImportController::class, 'store'])->name('admin.import.store');

    // Profile Management (Laravel Breeze Default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';