<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all pastes for the user (DataTables will handle pagination & search)
        $pastes = auth()->user()->pastes()->withoutGlobalScopes()->latest()->get();

        return view('dashboard.index', compact('pastes')); // Update view path if necessary based on your structure
    }
}
