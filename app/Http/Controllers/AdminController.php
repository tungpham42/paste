<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\User;
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
        // Added 'pastes_page' to prevent pagination conflicts with the users tab
        $pastes = Paste::withoutGlobalScopes()
            ->with('user')
            ->latest()
            ->paginate($perPage, ['*'], 'pastes_page')
            ->appends($request->query());

        // Fetch all users for the new Admin Dashboard tab
        // Added 'users_page' to prevent pagination conflicts with the pastes tab
        $users = User::latest()
            ->paginate($perPage, ['*'], 'users_page')
            ->appends($request->query());

        // Pass both variables to the view
        return view('admin.dashboard', compact('pastes', 'users', 'perPage'));
    }

    public function destroy($slug)
    {
        // Admin can delete any paste
        $paste = Paste::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        $paste->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Paste permanently deleted by Admin.');
    }

    public function destroyUser(User $user)
    {
        // Prevent admins from deleting themselves
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User permanently deleted from the platform.');
    }
}
