<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $allowedPerPage = [5, 10, 20, 50, 100];
        $perPage = $request->input('per_page', 10);

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        // Fetch all pastes for the user, including expired ones, paginated
        $pastes = auth()->user()
            ->pastes()
            ->withoutGlobalScopes()
            ->latest()
            ->paginate($perPage)
            ->appends($request->query());

        return view('dashboard.index', compact('pastes', 'perPage'));
    }
}
