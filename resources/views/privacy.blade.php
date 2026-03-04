@extends('layouts.app')

@section('title', 'Privacy Policy - SOFT Paste')

@section('content')
<div class="max-w-4xl mx-auto w-full pb-12">
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 md:p-12 transition-colors duration-200">

        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">Privacy Policy</h1>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-8 border-b border-slate-100 dark:border-slate-800 pb-8">
            Last Updated: {{ date('F j, Y') }}
        </p>

        <div class="space-y-8 text-slate-600 dark:text-slate-300 leading-relaxed">

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">1. Information We Collect</h2>
                <p class="mb-3">When you use SOFT Paste, we may collect the following types of information:</p>
                <ul class="list-disc list-outside ml-5 space-y-2 marker:text-indigo-500 dark:marker:text-indigo-400">
                    <li><strong>Account Information:</strong> If you log in using Google, we collect your name, email address, and profile picture to create and manage your account.</li>
                    <li><strong>Content:</strong> The text, code snippets, and settings (like passwords for protected pastes) you choose to save on our platform.</li>
                    <li><strong>Usage Data:</strong> We may collect standard server logs including your IP address, browser type, operating system, and the timestamps of your visits.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">2. How We Use Your Information</h2>
                <p class="mb-3">We use the information we collect for the following purposes:</p>
                <ul class="list-disc list-outside ml-5 space-y-2 marker:text-indigo-500 dark:marker:text-indigo-400">
                    <li>To provide, maintain, and improve the SOFT Paste service.</li>
                    <li>To securely associate your pastes with your user account.</li>
                    <li>To detect, prevent, and address technical issues, spam, or abusive behavior.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">3. Cookies and Third-Party Services</h2>
                <p>
                    We use cookies and similar tracking technologies to track the activity on our service. We also use third-party services like <strong>Google Analytics</strong> to understand how our site is used, and <strong>Google AdSense</strong> to serve ads. These third parties may use cookies to serve ads based on your prior visits to our website or other websites.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">4. Data Security</h2>
                <p>
                    We take reasonable measures to help protect your personal information and the content of your pastes from loss, theft, misuse, unauthorized access, disclosure, alteration, and destruction. However, no internet transmission is ever fully secure or error-free.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">5. Contact Us</h2>
                <p>
                    If you have any questions about this Privacy Policy or wish to request the deletion of your data, please contact us at <a href="mailto:support@softpaste.com" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">support@softpaste.com</a>.
                </p>
            </section>

        </div>
    </div>
</div>
@endsection
