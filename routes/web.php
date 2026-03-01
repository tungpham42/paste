<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasteController;
use App\Http\Controllers\Auth\GoogleOneTapController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\EnsureUserIsAdmin;

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
// Admin Routes (MUST go above the wildcard)
// -----------------------------------------------------------------------------
Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::delete('/pastes/{slug}', [AdminController::class, 'destroy'])->name('pastes.destroy');

    // New route for deleting users from the admin dashboard
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
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
// Authentication Routes
// -----------------------------------------------------------------------------
Route::post('/auth/google/verify', [GoogleOneTapController::class, 'verify'])->name('auth.google.verify');
Route::view('/login', 'login')->name('login')->middleware('guest');

// -----------------------------------------------------------------------------
// Authenticated Routes
// -----------------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/pastes/{slug}', [PasteController::class, 'destroy'])->name('pastes.destroy');
    Route::post('/logout', [GoogleOneTapController::class, 'logout'])->name('logout');
});

// -----------------------------------------------------------------------------
// Sitemap Route (MUST go above the wildcard)
// -----------------------------------------------------------------------------
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// -----------------------------------------------------------------------------
// Wildcard Route (Must go LAST)
// -----------------------------------------------------------------------------
Route::get('/{paste}/raw', [PasteController::class, 'raw'])->name('pastes.raw');
Route::get('/{paste}/download', [PasteController::class, 'download'])->name('pastes.download');

// This allows short, clean URLs like: softpaste.com/aB8x9Z
Route::get('/{paste}', [PasteController::class, 'show'])->name('pastes.show');
