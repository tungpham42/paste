<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Paste;

Schedule::call(function () {
    Paste::withoutGlobalScopes()
        ->whereNotNull('expires_at')
        ->where('expires_at', '<', now())
        ->delete();
})->hourly();
