<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $allowedPerPage = [5, 10, 20, 50, 100];
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $query = auth()->user()->pastes()->withoutGlobalScopes();

        // Apply search filter if a query exists
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('syntax', 'like', '%' . $search . '%');
            });
        }

        // Fetch all pastes for the user, including expired ones, paginated
        $pastes = $query->latest()
            ->paginate($perPage)
            ->appends($request->query());

        return view('dashboard.index', compact('pastes', 'perPage', 'search'));
    }
}
