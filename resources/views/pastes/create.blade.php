@extends('layouts.app')

@section('title', 'Create New Paste - SOFT Paste')

@section('content')
<div class="max-w-4xl mx-auto w-full bg-white p-6 md:p-10 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 mt-4 md:mt-8">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 tracking-tight">What are we saving today?</h2>
        <p class="text-slate-500 mt-1 text-sm">Drop your code, text, or configuration files below.</p>
    </div>

    <form action="{{ route('pastes.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <textarea name="content" rows="14"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl p-5 font-mono text-sm focus:bg-white focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all resize-y @error('content') border-rose-500 focus:ring-rose-500/20 @enderror"
                placeholder="Paste your brilliant code or text here..." required></textarea>

            @error('content')
                <p class="text-rose-500 text-sm mt-2 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-slate-50/50 p-6 rounded-xl border border-slate-100">
            <div>
                <label class="block font-semibold text-sm text-slate-700 mb-2">Syntax</label>
                <select name="syntax" class="w-full bg-white border border-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm cursor-pointer transition">
                    <option value="plaintext">None (Plain Text)</option>
                    <option value="php">PHP</option>
                    <option value="javascript">JavaScript</option>
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="python">Python</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 mb-2">Visibility</label>
                <select name="visibility" class="w-full bg-white border border-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm cursor-pointer transition">
                    <option value="public">🌍 Public</option>
                    <option value="unlisted">🔗 Unlisted</option>
                    <option value="private">🔒 Private</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 mb-2">Password (Optional)</label>
                <input type="password" name="password" placeholder="Keep it secret..."
                    class="w-full bg-white border border-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition">
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 mb-2">Expiration</label>
                <select name="expiration_minutes" class="w-full bg-white border border-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm cursor-pointer transition">
                    <option value="">Never expire</option>
                    <option value="10">10 Minutes</option>
                    <option value="60">1 Hour</option>
                    <option value="1440">1 Day</option>
                    <option value="10080">1 Week</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-slate-500 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Free limit: <strong>512KB</strong>. <a href="#" class="text-indigo-600 hover:underline">Go Pro</a> for 10MB limits.</span>
            </div>
            <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl transition-all shadow-md shadow-indigo-500/30 hover:shadow-lg hover:shadow-indigo-500/40 transform hover:-translate-y-0.5">
                Save & Share Paste
            </button>
        </div>
    </form>
</div>
@endsection
