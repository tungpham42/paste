@extends('layouts.app')

@section('title', ($paste->title ?? 'Untitled Paste') . ' - SOFT Paste')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
    <style>
        pre[class*="language-"] {
            border-radius: 0.75rem !important;
            margin: 0 !important;
            box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);
        }

        /* Force Wrap overrides for Prism */
        pre.whitespace-pre-wrap {
            white-space: pre-wrap !important;
            word-break: break-word !important;
            padding-left: 1.5rem !important; /* Reset padding when line numbers are hidden */
        }
        code.whitespace-pre-wrap {
            white-space: pre-wrap !important;
            word-break: break-word !important;
        }
        /* Hide Prism line numbers when wrapped (physical lines != visual wraps) */
        pre.whitespace-pre-wrap .line-numbers-rows {
            display: none !important;
        }
    </style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto w-full bg-white dark:bg-slate-900 p-6 md:p-8 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 mt-4 transition-colors" x-data="{ wrapText: false }">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 dark:border-slate-800 pb-6 mb-6">
        <div class="flex-1">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-4">{{ $paste->title ?? 'Untitled Paste' }}</h1>

            <div class="flex flex-wrap items-center gap-2 text-xs font-medium">
                <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-3 py-1.5 rounded-md flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ $paste->user?->name ?? 'Guest' }}
                </span>

                <span class="bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 px-3 py-1.5 rounded-md flex items-center gap-1 uppercase border dark:border-indigo-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    {{ $paste->syntax }}
                </span>

                <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 px-3 py-1.5 rounded-md">
                    {{ ucfirst($paste->visibility) }}
                </span>

                <span class="bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-3 py-1.5 rounded-md">
                    {{ $paste->created_at->format('M d, Y h:i A') }}
                </span>

                @if($paste->expires_at)
                    <span class="bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 px-3 py-1.5 rounded-md flex items-center gap-1 border border-rose-100 dark:border-rose-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Expires {{ $paste->expires_at->diffForHumans() }}
                    </span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-1 text-slate-500 shrink-0 w-full md:w-auto justify-end">
            <span class="text-sm font-semibold mr-2 text-slate-400 dark:text-slate-500 uppercase tracking-wider">Share</span>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="p-2 text-slate-400 dark:text-slate-500 hover:text-[#1877F2] dark:hover:text-[#1877F2] hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-full transition-all">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            </a>

            <a href="https://twitter.com/intent/tweet?text={{ urlencode($paste->title ?? 'Untitled Paste') }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="p-2 text-slate-400 dark:text-slate-500 hover:text-black dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path></svg>
            </a>

            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" class="p-2 text-slate-400 dark:text-slate-500 hover:text-[#0A66C2] dark:hover:text-[#0A66C2] hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-full transition-all">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z"></path></svg>
            </a>
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-start md:justify-end gap-3 w-full mb-6">
        <button @click="wrapText = !wrapText" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-xl transition-all text-sm font-semibold shadow-sm"
                :class="wrapText ? 'ring-2 ring-indigo-500 border-indigo-500 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/20' : ''">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            <span x-text="wrapText ? 'Unwrap' : 'Wrap'"></span>
        </button>

        <a href="{{ route('pastes.raw', $paste) }}" target="_blank" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-xl transition-all text-sm font-semibold shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
            Raw
        </a>

        <a href="{{ route('pastes.download', $paste) }}" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-xl transition-all text-sm font-semibold shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Download
        </a>

        <button onclick="copyCode()" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-xl transition-all text-sm font-semibold shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Copy
        </button>

        <a href="{{ route('pastes.create') }}" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl transition-all text-sm font-semibold shadow-sm shadow-indigo-500/30 dark:shadow-indigo-900/40">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New
        </a>
    </div>

    <div class="rounded-xl overflow-hidden shadow-sm border border-slate-800 dark:border-slate-700 bg-[#272822]">
        <pre class="line-numbers" :class="wrapText ? 'whitespace-pre-wrap' : ''"><code class="language-{{ $paste->syntax === 'plaintext' ? 'none' : $paste->syntax }}" id="code-block" :class="wrapText ? 'whitespace-pre-wrap' : ''">{{ $paste->content }}</code></pre>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script>
        // Tell the autoloader where to find the language grammar files
        Prism.plugins.autoloader.languages_path = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/';

        function copyCode() {
            const codeBlock = document.getElementById('code-block').innerText;
            navigator.clipboard.writeText(codeBlock).then(() => {
                const isDark = document.documentElement.classList.contains('dark');

                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: 'success',
                    title: '✨ Code copied to clipboard!',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: isDark ? '#1e293b' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#0f172a',
                    iconColor: '#10b981'
                });
            }).catch(err => {
                console.error('Failed to copy text: ', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to copy text to clipboard.',
                });
            });
        }
    </script>
@endpush
