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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Lexend Deca', sans-serif; }
        [x-cloak] { display: none !important; } /* Prevents Alpine flash */

        /* Optional: Tweaks to make SweetAlert2 border-radius match your app */
        div:where(.swal2-container) div:where(.swal2-popup) {
            border-radius: 1rem;
        }

        /* Firefox Scrollbar */
        html {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f8fafc; /* slate-300 thumb, slate-50 track */
        }
        html.dark {
            scrollbar-color: #334155 #0f172a; /* slate-700 thumb, slate-950 track */
        }

        /* Webkit Scrollbar (Chrome, Edge, Safari) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f8fafc; /* slate-50 */
        }
        html.dark ::-webkit-scrollbar-track {
            background: #0f172a; /* slate-950 */
        }

        /* Thumb */
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* slate-300 */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* slate-400 */
        }

        /* Dark Mode Thumb */
        html.dark ::-webkit-scrollbar-thumb {
            background: #334155; /* slate-700 */
        }
        html.dark ::-webkit-scrollbar-thumb:hover {
            background: #475569; /* slate-600 */
        }
    </style>

    @stack('styles')

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HHXZSNQ65X"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag("js", new Date());
      gtag("config", "G-HHXZSNQ65X");
    </script>
</head>
<body class="bg-[#f8fafc] dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased selection:bg-indigo-100 dark:selection:bg-indigo-900/50 selection:text-indigo-900 dark:selection:text-indigo-200 flex flex-col min-h-screen transition-colors duration-200">

    <nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-100 dark:border-slate-800 px-6 py-4 transition-all">
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
                    <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="menu-icon-close" class="hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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

        <div class="w-full max-w-7xl mx-auto mb-6 flex justify-center overflow-hidden">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536"
                crossorigin="anonymous"></script>
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-3585118770961536"
                data-ad-slot="6189357295"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

        @yield('content')
    </main>

    <button
        x-data="{ show: false }"
        @scroll.window="show = window.pageYOffset > 200"
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-40 p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg shadow-indigo-500/30 dark:shadow-indigo-900/40 transition-colors focus:outline-none focus:ring-4 focus:ring-indigo-500/20 group"
        aria-label="Back to top"
        style="display: none;"
    >
        <svg class="w-5 h-5 transform group-hover:-translate-y-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
    </button>

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

        // Updated mobile menu logic to toggle icons
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            var iconOpen = document.getElementById('menu-icon-open');
            var iconClose = document.getElementById('menu-icon-close');

            menu.classList.toggle('hidden');

            if (menu.classList.contains('hidden')) {
                iconOpen.classList.remove('hidden');
                iconClose.classList.add('hidden');
            } else {
                iconOpen.classList.add('hidden');
                iconClose.classList.remove('hidden');
            }
        });
    </script>

    @stack('scripts')

    <script>
        // Updated to accept itemName dynamically
        function confirmDelete(event, form, itemName = 'paste') {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: `Permanently delete this ${itemName}? This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none',
                    title: 'text-slate-800 dark:text-white font-bold text-xl',
                    htmlContainer: 'text-slate-500 dark:text-slate-400 text-sm mt-2',
                    actions: 'gap-3 w-full px-6 pb-6',
                    confirmButton: 'flex-1 justify-center flex items-center bg-rose-500 hover:bg-rose-600 text-white px-4 py-2.5 rounded-xl transition-all font-semibold shadow-sm',
                    cancelButton: 'flex-1 justify-center flex items-center bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 border border-transparent dark:border-slate-700 px-4 py-2.5 rounded-xl transition-all font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

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
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: 'Could not log in. Please try again.',
                            buttonsStyling: false,
                            customClass: {
                                popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl',
                                title: 'text-slate-800 dark:text-white font-bold',
                                htmlContainer: 'text-slate-500 dark:text-slate-400 mt-2 text-sm',
                                confirmButton: 'w-full justify-center flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl transition-all font-semibold shadow-sm mt-4'
                            }
                        });
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
        <div id="toast-alert" class="fixed bottom-24 md:bottom-28 right-6 z-50 flex items-center w-full max-w-sm p-4 text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 transition-all duration-500 transform translate-y-0 opacity-100" role="alert">
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
</body>
</html>
