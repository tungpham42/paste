@extends('layouts.app')

@section('title', 'My Dashboard - SOFT Paste')

@section('content')
<div class="max-w-7xl mx-auto w-full mt-4 p-6 md:p-8 bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 transition-colors">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">My Dashboard</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage all your saved code snippets and texts.</p>
        </div>
        <a href="{{ route('pastes.create') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl transition-all font-semibold shadow-sm shadow-indigo-500/30 dark:shadow-indigo-900/40">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Paste
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 font-medium">
            <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 p-4">
        <table id="pastesTable" class="w-full text-left border-collapse stripe hover">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Title</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Syntax</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Visibility</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Status</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Created</th>
                    <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach($pastes as $paste)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition group">
                        <td class="p-4 font-medium">
                            <a href="{{ route('pastes.show', $paste) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition">
                                {{ $paste->title ?? 'Untitled Snippet' }}
                            </a>
                        </td>
                        <td class="p-4 text-xs font-bold tracking-wide uppercase text-slate-500 dark:text-slate-400">{{ $paste->syntax }}</td>
                        <td class="p-4 text-sm capitalize text-slate-600 dark:text-slate-300 flex items-center gap-1.5">
                            @if($paste->visibility === 'public') 🌍
                            @elseif($paste->visibility === 'unlisted') 🔗
                            @else 🔒 @endif
                            {{ $paste->visibility }}
                        </td>
                        <td class="p-4">
                            @if($paste->expires_at && $paste->expires_at->isPast())
                                <span class="bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 px-2.5 py-1 rounded-md text-xs font-bold tracking-wide border border-rose-100 dark:border-rose-500/20">Expired</span>
                            @else
                                <span class="bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-2.5 py-1 rounded-md text-xs font-bold tracking-wide border border-emerald-100 dark:border-emerald-500/20">Active</span>
                            @endif
                        </td>
                        <td class="p-4 text-sm text-slate-500 dark:text-slate-400" data-order="{{ $paste->created_at->timestamp }}">
                            {{ $paste->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end items-center gap-3">
                                <a target="_blank" href="{{ route('pastes.show', $paste) }}" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition">View</a>
                                <form action="{{ route('pastes.destroy', $paste->slug) }}" method="POST" onsubmit="confirmDelete(event, this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-700 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#pastesTable').DataTable({
            responsive: true,
            order: [[4, 'desc']], // Sort by "Created" column descending
            language: {
                search: "", // Remove "Search:" label
                searchPlaceholder: "Search snippets...",
                emptyTable: "Looks like your dashboard is a blank slate. Let's create your first paste!"
            },
            columnDefs: [
                { orderable: false, targets: 5 } // Disable sorting on the Actions column
            ]
        });
    });
</script>
@endpush
@endsection
