<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasteController;
use App\Http\Controllers\Auth\GoogleOneTapController;

// -----------------------------------------------------------------------------
// Public Routes
// -----------------------------------------------------------------------------

// Homepage is the Create Paste form
Route::get('/', [PasteController::class, 'create'])->name('pastes.create');

// Save the paste
Route::post('/pastes', [PasteController::class, 'store'])->name('pastes.store');

// Unlock a protected paste
Route::post('/pastes/{paste}/unlock', [PasteController::class, 'unlock'])->name('pastes.unlock.store');

// -----------------------------------------------------------------------------
// Authenticated Routes
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/pastes/{paste}', [PasteController::class, 'destroy'])->name('pastes.destroy');
});

// -----------------------------------------------------------------------------
// Wildcard Route (Must go LAST)
// -----------------------------------------------------------------------------
// This allows short, clean URLs like: softpaste.com/aB8x9Z
Route::get('/{paste}', [PasteController::class, 'show'])->name('pastes.show');

Route::post('/auth/google/verify', [GoogleOneTapController::class, 'verify'])->name('auth.google.verify');
