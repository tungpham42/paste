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
    function applyCustomAlpineLengthMenu(tableId, itemLabel) {
        const dtLengthContainer = $('#' + tableId + '_wrapper .dt-length');
        if (dtLengthContainer.length) {
            dtLengthContainer.children().hide();
            const dropdownHTML = `
                <div class="flex items-center gap-3">
                    <label class="font-semibold text-sm text-slate-700 dark:text-slate-300">Show</label>
                    <div x-data="{
                        open: false, dropUp: false, value: '10',
                        options: { '10': '10', '25': '25', '50': '50', '100': '100' },
                        get selectedLabel() { return this.options[this.value]; },
                        reposition() {
                            if (!this.$refs.button) return;
                            const rect = this.$refs.button.getBoundingClientRect();
                            const spaceBelow = window.innerHeight - rect.bottom;
                            this.dropUp = spaceBelow < 260 && rect.top > spaceBelow;
                        }
                    }"
                    @click.away="open = false" @scroll.window="open ? reposition() : null" @resize.window="open ? reposition() : null"
                    class="relative min-w-[4.5rem]">
                        <button x-ref="button" @click="open = !open; if(open) $nextTick(() => reposition())" type="button" class="w-full flex items-center justify-between bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 py-1.5 px-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition shadow-sm">
                            <span x-text="selectedLabel"></span>
                            <svg class="w-4 h-4 text-slate-400 transition-transform ml-2" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <ul x-show="open" x-transition.opacity.duration.200ms :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'" class="absolute z-50 w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto py-1 text-sm" style="display: none;">
                            <template x-for="(label, key) in options" :key="key">
                                <li @click="value = key; open = false; $('#${tableId}').DataTable().page.len(parseInt(key)).draw();" class="px-4 py-2 cursor-pointer transition-colors" :class="value === key ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400'">
                                    <span x-text="label"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <label class="font-semibold text-sm text-slate-700 dark:text-slate-300">${itemLabel} per page</label>
                </div>
            `;
            dtLengthContainer.append(dropdownHTML);
        }
    }

    function applyCustomSearchStyling(tableId) {
        const dtSearchContainer = $('#' + tableId + '_wrapper .dt-search');
        if (dtSearchContainer.length) {
            dtSearchContainer.find('label').addClass('font-semibold text-sm text-slate-700 dark:text-slate-300 mr-2');
            const input = dtSearchContainer.find('input');
            input.removeClass().addClass('bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 py-1.5 px-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition shadow-sm placeholder:text-slate-400 dark:placeholder:text-slate-500');
        }
    }

    $(document).ready(function() {
        $('#pastesTable').DataTable({
            responsive: true, order: [[4, 'desc']],
            language: {
                search: "", searchPlaceholder: "Search pastes...",
                info: "Showing _START_ to _END_ of _TOTAL_ snippets",
                infoEmpty: "Showing 0 to 0 of 0 snippets", infoFiltered: "(filtered from _MAX_ total snippets)",
                emptyTable: "Looks like your dashboard is a blank slate. Let's create your first paste!"
            },
            columnDefs: [{ orderable: false, targets: 5 }]
        });

        applyCustomAlpineLengthMenu('pastesTable', 'snippets');
        applyCustomSearchStyling('pastesTable');
    });
</script>
@endpush
@endsection
