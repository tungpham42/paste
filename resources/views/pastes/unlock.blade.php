@extends('layouts.app')

@section('title', 'Unlock Paste - SOFT Paste')

@section('content')
<div class="flex-grow flex items-center justify-center">
    <div class="max-w-md w-full bg-white dark:bg-slate-900 p-8 md:p-10 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 transition-colors">

        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 rounded-2xl flex items-center justify-center mx-auto mb-5 rotate-3 shadow-sm border border-indigo-100 dark:border-indigo-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Protected Snippet</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-2 leading-relaxed">This code is locked away. Don't worry, just enter the secret password below to reveal it.</p>
        </div>

        <form action="{{ route('pastes.unlock.store', $paste) }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                <input type="password" id="password" name="password" required autofocus placeholder="Enter password..."
                    class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 px-4 py-3 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500 @error('password') border-rose-500 focus:ring-rose-500/20 @enderror">

                @error('password')
                    <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-md shadow-indigo-500/30 dark:shadow-indigo-900/40 transform hover:-translate-y-0.5">
                Unlock Paste
            </button>

            <div class="mt-6 text-center">
                <a href="{{ route('pastes.create') }}" class="text-sm font-medium text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition">← Nevermind, go back</a>
            </div>
        </form>
    </div>
</div>
@endsection
