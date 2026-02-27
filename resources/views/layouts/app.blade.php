<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta
      name="description"
      content="SOFT Paste - Your go-to platform for sharing code snippets and text online with ease and security."
    />
    <meta property="og:image" content="{{ asset('1200x630.jpg') }}" />
    <meta
      property="og:image:alt"
      content="SOFT Paste - Your go-to platform for sharing code snippets and text online with ease and security."
    />
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

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Lexend Deca', sans-serif; background-color: #f8fafc; /* Softer slate-50 */ }
    </style>

    @stack('styles')

    <!-- Google tag (gtag.js) -->
    <script
      async
      src="https://www.googletagmanager.com/gtag/js?id=G-HHXZSNQ65X"
    ></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag() {
        dataLayer.push(arguments);
      }
      gtag("js", new Date());

      gtag("config", "G-HHXZSNQ65X");
    </script>
    <script
      async
      src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3585118770961536"
      crossorigin="anonymous"
    ></script>
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900 flex flex-col min-h-screen">

    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-slate-100 px-6 py-4 flex justify-between items-center transition-all">
        <div class="text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-500">
            <a href="{{ route('pastes.create') }}">SOFT Paste</a>
        </div>

        @auth
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="hidden md:block text-sm font-medium text-slate-500 hover:text-indigo-600 transition">My Dashboard</a>

                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="flex flex-col text-right">
                        <span class="text-sm font-bold text-slate-700 leading-none">{{ auth()->user()->name }}</span>
                    </div>

                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-indigo-100 shadow-sm transition hover:scale-105" referrerpolicy="no-referrer">
                    @else
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 text-white flex items-center justify-center font-bold shadow-sm">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="ml-2">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-slate-500 hover:text-rose-600 transition-colors p-2 rounded-md hover:bg-rose-50" title="Log Out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div>
                <button id="google-login-btn" class="text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 hover:text-indigo-600 px-5 py-2.5 rounded-full transition-all">
                    Log In
                </button>
            </div>
        @endauth
    </nav>

    <main class="p-6 flex-grow flex flex-col">
        @yield('content')
    </main>

    @stack('scripts')
    @guest
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <script>
            function handleCredentialResponse(response) {
                // Send the securely signed Google token to our Laravel backend
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
                        // Success! Send them to the dashboard
                        window.location.href = data.redirect;
                    } else {
                        console.error('Login failed:', data.message);
                        alert('Could not log in. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Network Error:', error);
                });
            }

            window.onload = function () {
                google.accounts.id.initialize({
                    client_id: '{{ config('services.google.client_id') }}',
                    callback: handleCredentialResponse,
                    auto_select: false, // Set to true if you want returning users to auto-login without clicking
                    cancel_on_tap_outside: true // Users can click outside the prompt to dismiss it
                });

                // Show the floating Google One Tap prompt on the right side
                google.accounts.id.prompt();

                // Bind the manual login button in your navigation bar
                const loginBtn = document.getElementById('google-login-btn');
                if(loginBtn) {
                    loginBtn.addEventListener('click', () => {
                        // If they closed the prompt, this forces it to appear again
                        google.accounts.id.prompt();
                    });
                }
            }
        </script>
    @endguest
    @if (session('status') || session('success'))
        <div id="toast-alert" class="fixed bottom-6 right-6 z-50 flex items-center w-full max-w-sm p-4 text-slate-600 bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 transition-all duration-500 transform translate-y-0 opacity-100" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-emerald-500 bg-emerald-50 rounded-xl border border-emerald-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="ml-3 text-sm font-semibold text-slate-700">
                {{ session('status') ?? session('success') }}
            </div>
            <button type="button" onclick="closeToast()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-rose-500 rounded-lg focus:ring-2 focus:ring-slate-100 p-1.5 hover:bg-slate-50 inline-flex h-8 w-8 items-center justify-center transition-colors">
                <span class="sr-only">Close</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <script>
            // Function to smoothly animate the toast away
            function closeToast() {
                const toast = document.getElementById('toast-alert');
                if (toast) {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-4', 'opacity-0');
                    setTimeout(() => toast.remove(), 500); // Wait for transition to finish
                }
            }

            // Auto-dismiss after 4 seconds
            setTimeout(closeToast, 4000);
        </script>
    @endif
</body>
</html>
