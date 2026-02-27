@extends('layouts.app')

@section('title', 'Log In - SOFT Paste')

@section('content')
<div class="flex-grow flex items-center justify-center">
    <div class="max-w-md w-full bg-white dark:bg-slate-900 shadow-xl rounded-3xl p-8 border border-slate-100 dark:border-slate-800 text-center transition-colors">

        <div class="mb-6 flex justify-center">
            <div class="w-16 h-16 bg-gradient-to-tr from-indigo-100 to-violet-100 dark:from-indigo-900/40 dark:to-violet-900/40 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-extrabold text-slate-800 dark:text-slate-100 mb-2 tracking-tight">Welcome Back</h1>
        <p class="text-slate-500 dark:text-slate-400 mb-8 font-light">Sign in to manage your pastes and access your secure dashboard.</p>

        <div class="flex justify-center mb-6 min-h-[44px]">
            <div id="google-signin-button"></div>
        </div>

        <p class="text-xs text-slate-400 dark:text-slate-500 mt-6 font-light">
            By continuing, you agree to our Terms of Service and Privacy Policy.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const renderGoogleButton = setInterval(() => {
        if (typeof google !== 'undefined' && google.accounts && google.accounts.id) {

            // 1. Explicitly initialize here to bypass the window.onload delay in app.blade.php.
            // This guarantees the client is ready before we attempt to render the button.
            google.accounts.id.initialize({
                client_id: '{{ config('services.google.client_id') }}',
                callback: handleCredentialResponse,
            });

            // 2. Determine the current theme
            const isDark = document.documentElement.classList.contains('dark');

            // 3. Render the standard button (This bypasses any One Tap rate limits/thresholds)
            google.accounts.id.renderButton(
                document.getElementById("google-signin-button"),
                {
                    theme: isDark ? 'filled_black' : 'outline',
                    size: "large",
                    shape: "pill",
                    type: "standard",
                    text: "signin_with"
                }
            );

            clearInterval(renderGoogleButton);
        }
    }, 100);

    // Re-render the button if the user toggles dark mode while on the page
    document.getElementById('theme-toggle')?.addEventListener('click', () => {
        setTimeout(() => {
            const isDark = document.documentElement.classList.contains('dark');
            document.getElementById("google-signin-button").innerHTML = ''; // Clear existing button
            google.accounts.id.renderButton(
                document.getElementById("google-signin-button"),
                { theme: isDark ? 'filled_black' : 'outline', size: "large", shape: "pill", type: "standard" }
            );
        }, 50);
    });
</script>
@endpush
