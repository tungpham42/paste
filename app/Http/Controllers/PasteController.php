<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasteController extends Controller
{
    /**
     * Display the homepage / creation form.
     */
    public function create()
    {
        return view('pastes.create');
    }

    /**
     * Store a newly created paste in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|max:524288', // 512KB limit
            'syntax' => 'required|string',
            'visibility' => [
                'required',
                'in:public,unlisted,private',
                function ($attribute, $value, $fail) {
                    if ($value === 'private' && !auth()->check()) {
                        $fail('You must be logged in to create a private paste.');
                    }
                },
            ],
            'password' => 'nullable|string|min:4',
            'expiration_minutes' => 'nullable|integer'
        ]);

        $paste = Paste::create([
            'user_id' => auth()->id(), // Will be null if guest
            'slug' => Str::random(8),
            // Set a default title based on syntax or just 'Untitled Snippet'
            'title' => filled($validated['title']) ? $validated['title'] : 'Untitled ' . strtoupper($validated['syntax'] === 'plaintext' ? 'Snippet' : $validated['syntax']),
            'content' => $validated['content'],
            'syntax' => $validated['syntax'],
            'visibility' => $validated['visibility'],
            // Hash the password if one was provided
            'password' => filled($validated['password']) ? Hash::make($validated['password']) : null,
            // Calculate the expiration timestamp
            'expires_at' => $validated['expiration_minutes'] ? now()->addMinutes((int) $validated['expiration_minutes']) : null,
        ]);

        return redirect()->route('pastes.show', $paste);
    }

    /**
     * Display the specified paste.
     */
    public function show(Request $request, Paste $paste)
    {
        // 1. Check Privacy (If private, only the owner can see it)
        if ($paste->visibility === 'private' && $paste->user_id !== auth()->id()) {
            abort(403, 'This snippet is private and you do not have permission to view it.');
        }

        // 2. Check Password Protection
        if ($paste->password) {
            // Check if they have the unlock key in their active session
            if (!$request->session()->has("unlocked_paste_{$paste->id}")) {
                return view('pastes.unlock', compact('paste'));
            }
        }

        // 3. Eager load the user relationship to display the name
        $paste->load('user');

        return view('pastes.show', compact('paste'));
    }

    /**
     * Handle the password submission to unlock a paste.
     */
    public function unlock(Request $request, Paste $paste)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Verify the typed password against the hashed database password
        if (Hash::check($request->password, $paste->password)) {
            // Grant access in the session
            $request->session()->put("unlocked_paste_{$paste->id}", true);

            return redirect()->route('pastes.show', $paste);
        }

        return back()->withErrors([
            'password' => 'The provided password was incorrect. Please try again.'
        ]);
    }

    /**
     * Delete the specified paste.
     */
    public function destroy($slug)
    {
        // 1. Fetch the paste by slug, explicitly ignoring the 'active' global scope
        $paste = Paste::withoutGlobalScopes()->where('slug', $slug)->firstOrFail();

        // 2. Ensure the logged-in user actually owns this paste
        if ($paste->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // 3. Delete it
        $paste->delete();

        return redirect()->route('dashboard')->with('success', 'Your snippet has been deleted successfully.');
    }

    /**
     * Display the raw content of the paste.
     */
    public function raw(Request $request, Paste $paste)
    {
        if (!$this->checkAccess($request, $paste)) {
            return redirect()->route('pastes.show', $paste);
        }

        return response($paste->content, 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Download the paste as a file.
     */
    public function download(Request $request, Paste $paste)
    {
        if (!$this->checkAccess($request, $paste)) {
            return redirect()->route('pastes.show', $paste);
        }

        // Determine file extension (fallback to .txt)
        $extension = $paste->syntax === 'plaintext' ? 'txt' : $paste->syntax;

        // Generate a safe filename
        $filename = Str::slug($paste->title ?: $paste->slug) . '.' . $extension;

        return response()->streamDownload(function () use ($paste) {
            echo $paste->content;
        }, $filename);
    }

    /**
     * Helper to verify privacy and password protection for raw/download endpoints.
     */
    private function checkAccess(Request $request, Paste $paste)
    {
        // 1. Check Privacy
        if ($paste->visibility === 'private' && $paste->user_id !== auth()->id()) {
            abort(403, 'This snippet is private and you do not have permission to view it.');
        }

        // 2. Check Password Protection
        if ($paste->password && !$request->session()->has("unlocked_paste_{$paste->id}")) {
            return false; // Indicates they need to be redirected to the unlock screen
        }

        return true;
    }
}
