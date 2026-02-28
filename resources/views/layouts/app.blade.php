<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SOFT Paste - Your go-to platform for sharing code snippets and text online with ease and security." />
    <meta property="og:image" content="{{ asset('1200x630.jpg') }}" />
    <meta property="og:image:alt" content="SOFT Paste - Your go-to platform for sharing code snippets and text online with ease and security." />
    <meta property="og:image:type" content="image/jpg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <title>@yield('title', 'SOFT Paste')</title>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <style>
        body { font-family: 'Lexend Deca', sans-serif; }
        /* Prevent scroll when modal is open */
        body.modal-open { overflow: hidden; }
    </style>

    @stack('styles')

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HHXZSNQ65X"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag("js", new Date());
      gtag("config", "G-HHXZSNQ65X");
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536" crossorigin="anonymous"></script>
</head>
<body class="bg-[#f8fafc] dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased selection:bg-indigo-100 dark:selection:bg-indigo-900/50 selection:text-indigo-900 dark:selection:text-indigo-200 flex flex-col min-h-screen transition-colors duration-200" x-data="{ isModalOpen: false }" :class="{ 'modal-open': isModalOpen }">

    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-40 shadow-sm border-b border-slate-100 dark:border-slate-800 px-6 py-4 transition-all">
        <div class="flex justify-between items-center">
            <div class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-500 dark:from-indigo-400 dark:to-violet-400">
                <a href="{{ route('pastes.create') }}">SOFT Paste</a>
            </div>

            <div class="flex items-center gap-3 md:gap-4">
                <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none rounded-full text-sm p-2 transition-colors">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                </button>

                <div class="hidden md:flex items-center gap-4">
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-rose-500 dark:text-rose-400 hover:text-rose-600 dark:hover:text-rose-300 transition mr-2">Admin Panel</a>
                        @endif
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition">My Dashboard</a>

                        <div class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-700">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-200 leading-none">{{ auth()->user()->name }}</span>

                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-indigo-100 dark:border-indigo-900 shadow-sm transition hover:scale-105" referrerpolicy="no-referrer">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 text-white flex items-center justify-center font-bold shadow-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors p-2 rounded-md hover:bg-rose-50 dark:hover:bg-rose-500/10" title="Log Out">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 px-5 py-2.5 rounded-full transition-all">
                            Log In
                        </a>
                    @endauth
                </div>

                <button id="mobile-menu-btn" type="button" class="md:hidden text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg p-2 transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-4">
            @auth
                <div class="flex items-center gap-3 mb-2 px-2">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full border border-indigo-100 dark:border-indigo-900 shadow-sm" referrerpolicy="no-referrer">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 text-white flex items-center justify-center font-bold shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="font-bold text-slate-700 dark:text-slate-200">{{ auth()->user()->name }}</div>
                </div>

                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="block px-2 font-bold text-rose-500 dark:text-rose-400">Admin Panel</a>
                @endif
                <a href="{{ route('dashboard') }}" class="block px-2 font-medium text-slate-600 dark:text-slate-300">My Dashboard</a>

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-2 py-2 rounded-lg bg-rose-50 dark:bg-rose-500/10 font-medium text-rose-600 dark:text-rose-400">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block text-center font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 py-3 rounded-xl transition-colors">
                    Log In
                </a>
            @endauth
        </div>
    </nav>

    <main class="p-6 flex-grow flex flex-col">
        @yield('content')
    </main>

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')

    @guest
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <script>
            function handleCredentialResponse(response) {
                fetch('{{ route('auth.google.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ credential: response.credential })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        console.error('Login failed:', data.message);
                        window.dispatchEvent(new CustomEvent('show-alert', { detail: 'Could not log in. Please try again.' }));
                    }
                })
                .catch(error => console.error('Network Error:', error));
            }

            window.onload = function () {
                google.accounts.id.initialize({
                    client_id: '{{ config('services.google.client_id') }}',
                    callback: handleCredentialResponse,
                    auto_select: false,
                    cancel_on_tap_outside: true
                });
                google.accounts.id.prompt();

                const loginBtn = document.getElementById('google-login-btn');
                if(loginBtn) {
                    loginBtn.addEventListener('click', () => {
                        google.accounts.id.prompt();
                    });
                }
            }
        </script>
    @endguest

    @if (session('status') || session('success'))
        <div id="toast-alert" class="fixed bottom-6 right-6 z-50 flex items-center w-full max-w-sm p-4 text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 transition-all duration-500 transform translate-y-0 opacity-100" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-emerald-500 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl border border-emerald-100 dark:border-emerald-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="ml-3 text-sm font-semibold text-slate-700 dark:text-slate-200">
                {{ session('status') ?? session('success') }}
            </div>
            <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white dark:bg-slate-800 text-slate-400 hover:text-rose-500 dark:hover:text-rose-400 rounded-lg focus:ring-2 focus:ring-slate-100 dark:focus:ring-slate-700 p-1.5 hover:bg-slate-50 dark:hover:bg-slate-700 inline-flex h-8 w-8 items-center justify-center transition-colors">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <script>
            function closeToast() {
                const toast = document.getElementById('toast-alert');
                if (toast) {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-4', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }
            }
            setTimeout(closeToast, 4000);
        </script>
    @endif

    <div x-data="{ show: false, message: '' }"
         @show-alert.window="message = $event.detail; show = true; isModalOpen = true"
         @keydown.escape.window="show = false; isModalOpen = false"
         class="relative z-[100]"
         aria-labelledby="modal-title" role="dialog" aria-modal="true"
         x-show="show" style="display: none;">

         <div x-show="show" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

         <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
             <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                 <div x-show="show" @click.away="show = false; isModalOpen = false" x-transition.opacity.scale.95 class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6 border border-slate-200 dark:border-slate-800">
                     <div class="mt-3 text-center sm:mt-5">
                         <h3 class="text-lg font-bold leading-6 text-slate-800 dark:text-white" id="modal-title">Notification</h3>
                         <div class="mt-2">
                             <p class="text-sm text-slate-500 dark:text-slate-400" x-text="message"></p>
                         </div>
                     </div>
                     <div class="mt-5 sm:mt-6">
                         <button type="button" @click="show = false; isModalOpen = false" class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">OK</button>
                     </div>
                 </div>
             </div>
         </div>
    </div>

    <div x-data="{ show: false, message: '', action: '' }"
         @show-confirm.window="message = $event.detail.message; action = $event.detail.action; show = true; isModalOpen = true"
         @keydown.escape.window="show = false; isModalOpen = false"
         class="relative z-[100]"
         aria-labelledby="confirm-modal-title" role="dialog" aria-modal="true"
         x-show="show" style="display: none;">

         <div x-show="show" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

         <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
             <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                 <div x-show="show" @click.away="show = false; isModalOpen = false" x-transition.opacity.scale.95 class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200 dark:border-slate-800">
                     <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                         <div class="sm:flex sm:items-start">
                             <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 dark:bg-rose-500/10 sm:mx-0 sm:h-10 sm:w-10">
                                 <svg class="h-6 w-6 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                 </svg>
                             </div>
                             <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                 <h3 class="text-lg font-bold leading-6 text-slate-800 dark:text-white" id="confirm-modal-title">Confirm Action</h3>
                                 <div class="mt-2">
                                     <p class="text-sm text-slate-500 dark:text-slate-400 font-medium" x-text="message"></p>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-800">
                         <form :action="action" method="POST" class="m-0 sm:ml-3">
                             @csrf
                             @method('DELETE')
                             <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-colors">Confirm Delete</button>
                         </form>
                         <button type="button" @click="show = false; isModalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white dark:bg-slate-800 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-slate-300 shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 sm:mt-0 sm:w-auto transition-colors">Cancel</button>
                     </div>
                 </div>
             </div>
         </div>
    </div>
</body>
</html>
