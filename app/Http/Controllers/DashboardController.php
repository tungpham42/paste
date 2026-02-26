<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all pastes for the user, including expired ones, paginated
        $pastes = auth()->user()
            ->pastes()
            ->withoutGlobalScopes()
            ->latest()
            ->paginate(10);

        return view('dashboard.index', compact('pastes'));
    }
}
