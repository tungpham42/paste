<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Fetch all pastes, globally ignoring the active scope to see expired ones
        $pastes = Paste::withoutGlobalScopes()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('admin.dashboard', compact('pastes'));
    }

    public function destroy($slug)
    {
        // Admin can delete any paste
        $paste = Paste::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        $paste->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Paste permanently deleted by Admin.');
    }
}
