<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $allowedPerPage = [5, 10, 20, 50, 100];
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 20;
        }

        $pastesQuery = Paste::withoutGlobalScopes()->with('user');
        $usersQuery = User::query();

        if ($search) {
            // Filter pastes by title, syntax, or the author's name
            $pastesQuery->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('syntax', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%');
                  });
            });

            // Filter users by name or email
            $usersQuery->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $pastes = $pastesQuery->latest()
            ->paginate($perPage, ['*'], 'pastes_page')
            ->appends($request->query());

        $users = $usersQuery->latest()
            ->paginate($perPage, ['*'], 'users_page')
            ->appends($request->query());

        return view('admin.dashboard', compact('pastes', 'users', 'perPage', 'search'));
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
