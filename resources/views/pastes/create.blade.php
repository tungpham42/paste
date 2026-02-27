@extends('layouts.app')

@section('title', 'Create New Paste - SOFT Paste')

@section('content')
<div class="max-w-4xl mx-auto w-full bg-white dark:bg-slate-900 p-6 md:p-10 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 mt-4 md:mt-8 transition-colors">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">What are we saving today?</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Drop your code, text, or configuration files below.</p>
    </div>

    <form action="{{ route('pastes.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 font-semibold text-lg text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 @error('title') border-rose-500 focus:ring-rose-500/20 @enderror"
                placeholder="Title (Optional)...">

            @error('title')
                <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-6">
            <textarea name="content" rows="14"
                class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5 font-mono text-sm text-slate-800 dark:text-slate-200 focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all resize-y placeholder:text-slate-400 dark:placeholder:text-slate-500 @error('content') border-rose-500 focus:ring-rose-500/20 @enderror"
                placeholder="Paste your brilliant code or text here..." required>{{ old('content') }}</textarea>

            @error('content')
                <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-slate-50/50 dark:bg-slate-800/30 p-6 rounded-xl border border-slate-100 dark:border-slate-700/50">
            <div>
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Syntax</label>
                <select name="syntax" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm cursor-pointer transition">
                    <option value="plaintext" {{ old('syntax') == 'plaintext' ? 'selected' : '' }}>None (Plain Text)</option>
                    <option value="php" {{ old('syntax') == 'php' ? 'selected' : '' }}>PHP</option>
                    <option value="javascript" {{ old('syntax') == 'javascript' ? 'selected' : '' }}>JavaScript</option>
                    <option value="html" {{ old('syntax') == 'html' ? 'selected' : '' }}>HTML</option>
                    <option value="css" {{ old('syntax') == 'css' ? 'selected' : '' }}>CSS</option>
                    <option value="python" {{ old('syntax') == 'python' ? 'selected' : '' }}>Python</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Visibility</label>
                <select name="visibility" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm cursor-pointer transition">
                    <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>🌍 Public</option>
                    <option value="unlisted" {{ old('visibility') == 'unlisted' ? 'selected' : '' }}>🔗 Unlisted</option>
                    <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>🔒 Private</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Password (Optional)</label>
                <input type="password" name="password" placeholder="Keep it secret..."
                    class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition">
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Expiration</label>
                <select name="expiration_minutes" class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm cursor-pointer transition">
                    <option value="" {{ old('expiration_minutes') == '' ? 'selected' : '' }}>Never expire</option>
                    <option value="10" {{ old('expiration_minutes') == '10' ? 'selected' : '' }}>10 Minutes</option>
                    <option value="60" {{ old('expiration_minutes') == '60' ? 'selected' : '' }}>1 Hour</option>
                    <option value="1440" {{ old('expiration_minutes') == '1440' ? 'selected' : '' }}>1 Day</option>
                    <option value="10080" {{ old('expiration_minutes') == '10080' ? 'selected' : '' }}>1 Week</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex flex-col md:flex-row items-center justify-end gap-4">
            <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl transition-all shadow-md shadow-indigo-500/30 dark:shadow-indigo-900/40 hover:shadow-lg transform hover:-translate-y-0.5">
                Save & Share Paste
            </button>
        </div>
    </form>
</div>
@endsection
