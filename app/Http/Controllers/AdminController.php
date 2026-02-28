<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Define allowed pagination amounts and get the current requested amount (default to 20)
        $allowedPerPage = [5, 10, 20, 50, 100];
        $perPage = $request->input('per_page', 10);

        // Fallback to 20 if the user manually tampers with the URL parameter
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 20;
        }

        // Fetch all pastes, globally ignoring the active scope to see expired ones
        $pastes = Paste::withoutGlobalScopes()
            ->with('user')
            ->latest()
            ->paginate($perPage)
            ->appends($request->query()); // Keeps the ?per_page parameter on page 2, 3, etc.

        return view('admin.dashboard', compact('pastes', 'perPage'));
    }

    public function destroy($slug)
    {
        // Admin can delete any paste
        $paste = Paste::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        $paste->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Paste permanently deleted by Admin.');
    }
}
