<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all records (DataTables will handle pagination & search)
        $pastes = Paste::withoutGlobalScopes()->with('user')->latest()->get();
        $users = User::latest()->get();

        return view('admin.dashboard', compact('pastes', 'users'));
    }

    public function destroy($slug)
    {
        $paste = Paste::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();
        $paste->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Paste permanently deleted by Admin.');
    }

    public function destroyUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User permanently deleted from the platform.');
    }
}
