@extends('layouts.app')

@section('title', 'Admin Dashboard - SOFT Paste')

@section('content')
<div class="max-w-7xl mx-auto w-full mt-4 p-6 md:p-8 bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-rose-100 dark:border-rose-900/30 transition-colors"
     x-data="{ activeTab: localStorage.getItem('adminActiveTab') || 'pastes' }"
     x-init="$watch('activeTab', value => localStorage.setItem('adminActiveTab', value))">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Admin Center
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage all snippets and users across the entire platform.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 font-medium">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex space-x-6 mb-6 border-b border-slate-200 dark:border-slate-800">
        <button @click="activeTab = 'pastes'"
                :class="activeTab === 'pastes' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                class="pb-3 border-b-2 font-semibold transition-colors focus:outline-none flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Snippets
        </button>
        <button @click="activeTab = 'users'"
                :class="activeTab === 'users' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300'"
                class="pb-3 border-b-2 font-semibold transition-colors focus:outline-none flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Users
        </button>
    </div>

    <div x-show="activeTab === 'pastes'" x-cloak>
        <div class="flex justify-end mb-4">
            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="font-medium">Show</span>

                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" type="button" class="flex items-center gap-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 rounded-lg py-1.5 px-3 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all cursor-pointer font-semibold shadow-sm min-w-[4rem] justify-between">
                        <span>{{ $perPage ?? 10 }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="open" x-transition.opacity.duration.200ms class="absolute right-0 z-20 mt-1 w-full min-w-[4rem] bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg py-1 text-sm text-center" style="display: none;">
                        @foreach([5, 10, 20, 50, 100] as $value)
                            <li>
                                <a href="{{ request()->fullUrlWithQuery(['per_page' => $value]) }}"
                                   class="block px-3 py-1.5 transition-colors {{ ($perPage ?? 10) == $value ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                                    {{ $value }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <span class="font-medium">entries</span>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Title</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Author</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Syntax</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Visibility</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Status</th>
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
                            <td class="p-4">
                                @if($paste->expires_at && $paste->expires_at->isPast())
                                    <span class="bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 px-2.5 py-1 rounded-md text-xs font-bold tracking-wide border border-rose-100 dark:border-rose-500/20">Expired</span>
                                @else
                                    <span class="bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-2.5 py-1 rounded-md text-xs font-bold tracking-wide border border-emerald-100 dark:border-emerald-500/20">Active</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-500 dark:text-slate-400">{{ $paste->created_at->format('M d, Y H:i') }}</td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <a target="_blank" href="{{ route('pastes.show', $paste) }}" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 transition">View</a>
                                    <form action="{{ route('admin.pastes.destroy', $paste) }}" method="POST" onsubmit="confirmDelete(event, this, 'paste');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-700 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-500">No pastes exist on the platform yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $pastes->links() ?? '' }}
        </div>
    </div>

    <div x-show="activeTab === 'users'" x-cloak>
        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 mt-4">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">User</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Email</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Role</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400">Joined Time</th>
                        <th class="p-4 font-semibold text-sm text-slate-600 dark:text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($users ?? [] as $user)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition group">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700" referrerpolicy="no-referrer">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-xs">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="font-medium text-slate-800 dark:text-slate-200">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                            <td class="p-4">
                                @if($user->is_admin)
                                    <span class="bg-indigo-50 dark:bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 px-2.5 py-1 rounded-md text-xs font-bold tracking-wide border border-indigo-100 dark:border-indigo-500/20">Admin</span>
                                @else
                                    <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-2.5 py-1 rounded-md text-xs font-bold tracking-wide border border-slate-200 dark:border-slate-700">User</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-500 dark:text-slate-400">{{ $user->created_at->format('M d, Y H:i') }}</td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="confirmDelete(event, this, 'user');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-rose-500 hover:text-rose-700 transition" @if(auth()->id() === $user->id) disabled title="You cannot delete yourself" class="opacity-50 cursor-not-allowed" @endif>Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">No users found on the platform.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() ?? '' }}
        </div>
    </div>

</div>
@endsection
