@extends('layouts.app')

@section('title', 'Admin Dashboard - SOFT Paste')

@section('content')
<div class="max-w-7xl mx-auto w-full mt-4 p-6 md:p-8 bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-rose-100 dark:border-rose-900/30 transition-colors">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Admin Center
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage all snippets across the entire platform.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 font-medium">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Title</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Author</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Syntax</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Visibility</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Created</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($pastes as $paste)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition group">
                        <td class="p-4 font-medium">
                            <a href="{{ route('pastes.show', $paste) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 transition">
                                {{ $paste->title ?? 'Untitled Snippet' }}
                            </a>
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-300">
                            {{ $paste->user ? $paste->user->name : 'Guest' }}
                        </td>
                        <td class="p-4 text-xs font-bold tracking-wide uppercase text-slate-500 dark:text-slate-400">{{ $paste->syntax }}</td>
                        <td class="p-4 text-sm capitalize text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                            @if($paste->visibility === 'public') 🌍
                            @elseif($paste->visibility === 'unlisted') 🔗
                            @else 🔒 @endif
                            {{ $paste->visibility }}
                        </td>
                        <td class="p-4 text-sm text-slate-500 dark:text-slate-400">{{ $paste->created_at->format('M d, Y H:i') }}</td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end items-center gap-3">
                                <a target="_blank" href="{{ route('pastes.show', $paste) }}" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition">View</a>
                                <form action="{{ route('admin.pastes.destroy', $paste) }}" method="POST" onsubmit="return confirm('ADMIN ACTION: Permanently delete this paste?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-700 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-slate-500">No pastes exist on the platform yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $pastes->links() }}
    </div>
</div>
@endsection
