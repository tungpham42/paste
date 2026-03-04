@extends('layouts.app')

@section('title', 'Terms of Service - SOFT Paste')

@section('content')
<div class="max-w-4xl mx-auto w-full pb-12">
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 md:p-12 transition-colors duration-200">

        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-4 tracking-tight">Terms of Service</h1>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-8 border-b border-slate-100 dark:border-slate-800 pb-8">
            Last Updated: {{ date('F j, Y') }}
        </p>

        <div class="space-y-8 text-slate-600 dark:text-slate-300 leading-relaxed">

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">1. Acceptance of Terms</h2>
                <p>
                    By accessing and using SOFT Paste, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by these terms, please do not use this service.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">2. Description of Service</h2>
                <p>
                    SOFT Paste provides users with a platform to store, share, and manage plain text and code snippets. We reserve the right to modify, suspend, or discontinue the service at any time without notice.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">3. User Conduct and Content</h2>
                <p class="mb-3">You agree not to use SOFT Paste to upload, post, or otherwise transmit content that:</p>
                <ul class="list-disc list-outside ml-5 space-y-2 marker:text-indigo-500 dark:marker:text-indigo-400">
                    <li>Is illegal, harmful, threatening, abusive, harassing, defamatory, or highly offensive.</li>
                    <li>Contains personally identifiable information of others without their explicit consent (doxxing).</li>
                    <li>Contains malicious code, viruses, or disrupts the integrity of the service.</li>
                    <li>Violates any patent, trademark, trade secret, copyright, or other proprietary rights.</li>
                </ul>
                <p class="mt-3">
                    We reserve the right to remove any content and ban any user account that violates these guidelines without prior notice.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">4. Intellectual Property</h2>
                <p>
                    You retain ownership of any intellectual property rights that you hold in the content you create. By submitting, posting, or displaying content on or through SOFT Paste, you grant us a worldwide, non-exclusive, royalty-free license to use, copy, reproduce, process, adapt, modify, publish, transmit, display, and distribute such content.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-3">5. Disclaimer of Warranties</h2>
                <p>
                    The service is provided on an "as is" and "as available" basis. SOFT Paste makes no representations or warranties of any kind, express or implied, as to the operation of their services or the information, content, or materials included on this site.
                </p>
            </section>

        </div>
    </div>
</div>
@endsection
