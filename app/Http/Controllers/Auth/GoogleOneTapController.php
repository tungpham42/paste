<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Google_Client;

class GoogleOneTapController extends Controller
{
    public function verify(Request $request)
    {
        $credential = $request->input('credential');
        $client = new Google_Client(['client_id' => config('services.google.client_id')]);

        $payload = $client->verifyIdToken($credential);

        if ($payload) {
            // Use updateOrCreate to sync the avatar if it changes on Google's end
            $user = User::updateOrCreate(
                ['google_id' => $payload['sub']],
                [
                    'name' => $payload['name'],
                    'email' => $payload['email'],
                    'avatar' => $payload['picture'] ?? null, // Capture the avatar URL
                    'password' => Hash::make(Str::random(32))
                ]
            );

            Auth::login($user, true);

            return response()->json([
                'message' => 'Login successful',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json(['message' => 'Authentication failed'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'You have been safely logged out.');
    }
}
