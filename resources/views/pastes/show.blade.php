@extends('layouts.app')

@section('title', ($paste->title ?? 'Untitled Paste') . ' - SOFT Paste')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <style>
        pre[class*="language-"] {
            border-radius: 0.75rem !important;
            margin: 0 !important;
            box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);
        }
    </style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto w-full bg-white p-6 md:p-8 rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 mt-4">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-slate-100 pb-6 mb-6">
        <div class="flex-1">
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 mb-4">{{ $paste->title ?? 'Untitled Paste' }}</h1>

            <div class="flex flex-wrap items-center gap-2 text-xs font-medium">
                <span class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-md flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ $paste->user_id ? $paste->user->name : 'Guest' }}
                </span>

                <span class="bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-md flex items-center gap-1 uppercase">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    {{ $paste->syntax }}
                </span>

                <span class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-md">
                    {{ ucfirst($paste->visibility) }}
                </span>

                <span class="bg-slate-100 text-slate-500 px-3 py-1.5 rounded-md">
                    {{ $paste->created_at->format('M d, Y h:i A') }}
                </span>

                @if($paste->expires_at)
                    <span class="bg-rose-50 text-rose-600 px-3 py-1.5 rounded-md flex items-center gap-1 border border-rose-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Expires {{ $paste->expires_at->diffForHumans() }}
                    </span>
                @endif
            </div>
        </div>

        <div class="flex shrink-0 gap-3 w-full md:w-auto">
            <button onclick="copyCode()" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 px-4 py-2.5 rounded-xl transition-all font-semibold shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                Copy
            </button>
            <a href="{{ route('pastes.create') }}" class="flex-1 md:flex-none justify-center flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl transition-all font-semibold shadow-sm shadow-indigo-500/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New
            </a>
        </div>
    </div>

    <div class="rounded-xl overflow-hidden shadow-sm border border-slate-800 bg-[#272822]">
        <pre><code class="language-{{ $paste->syntax === 'plaintext' ? 'none' : $paste->syntax }}" id="code-block">{{ $paste->content }}</code></pre>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup-templating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>

    <script>
        function copyCode() {
            const codeBlock = document.getElementById('code-block').innerText;
            navigator.clipboard.writeText(codeBlock).then(() => {
                // Using a simple alert for now, easily swappable for a toast!
                alert('✨ Code copied to clipboard!');
            }).catch(err => {
                console.error('Failed to copy text: ', err);
            });
        }
    </script>
@endpush
