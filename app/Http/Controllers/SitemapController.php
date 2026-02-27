<?php

namespace App\Http\Controllers;

use App\Models\Paste;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $pastes = Paste::where('visibility', 'public')->latest()->get();

        return response()->view('sitemap', [
            'pastes' => $pastes
        ])->header('Content-Type', 'text/xml');
    }
}
