<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SOFT Paste')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Lexend Deca', sans-serif; background-color: #f8fafc; /* Softer slate-50 */ }
    </style>

    @stack('styles')
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
                    if (data.success) {
                        // If login is successful, reload the page to update the UI
                        window.location.reload();
                    } else {
                        console.error('Login Failed:', data.message);
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
                    cancel_on_tap_outside: false
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
</body>
</html>
