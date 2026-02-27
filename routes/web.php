<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasteController;
use App\Http\Controllers\Auth\GoogleOneTapController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Cache;

Route::get('/test-redis', function () {
    // Check if the cache exists
    if (Cache::has('browser_test')) {
        return "Loaded from Redis Cache: " . Cache::get('browser_test');
    }

    // If not, set it for 1 minute (60 seconds)
    $message = "This is fresh data created at " . now();
    Cache::put('browser_test', $message, 60);

    return "Saved to Redis. Refresh the page! Data: " . $message;
});

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
    Route::post('/logout', [GoogleOneTapController::class, 'logout'])->name('logout');
});

// -----------------------------------------------------------------------------
// Wildcard Route (Must go LAST)
// -----------------------------------------------------------------------------

Route::post('/auth/google/verify', [GoogleOneTapController::class, 'verify'])->name('auth.google.verify');

// -----------------------------------------------------------------------------
// Sitemap Route (MUST go above the wildcard)
// -----------------------------------------------------------------------------
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// -----------------------------------------------------------------------------
// Wildcard Route (Must go LAST)
// -----------------------------------------------------------------------------
// This allows short, clean URLs like: softpaste.com/aB8x9Z
Route::get('/{paste}', [PasteController::class, 'show'])->name('pastes.show');
