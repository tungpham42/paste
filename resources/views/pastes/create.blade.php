@extends('layouts.app')

@section('title', 'Create New Paste - SOFT Paste')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-okaidia.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
    <style>
        pre[class*="language-"] {
            border-radius: 0.75rem !important;
            margin: 0 !important;
            box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 0.05);
        }

        /* Force Wrap overrides for Prism */
        pre.whitespace-pre-wrap {
            white-space: pre-wrap !important;
            word-break: break-word !important;
            padding-left: 1.5rem !important; /* Reset padding when line numbers are hidden */
        }
        code.whitespace-pre-wrap {
            white-space: pre-wrap !important;
            word-break: break-word !important;
        }
        /* Hide Prism line numbers when wrapped (physical lines != visual wraps) */
        pre.whitespace-pre-wrap .line-numbers-rows {
            display: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/prettier@2.8.8/standalone.js"></script>
    <script src="https://unpkg.com/prettier@2.8.8/parser-babel.js"></script>
    <script src="https://unpkg.com/prettier@2.8.8/parser-html.js"></script>
    <script src="https://unpkg.com/prettier@2.8.8/parser-postcss.js"></script>
    <script src="https://unpkg.com/prettier@2.8.8/parser-markdown.js"></script>
    <script src="https://unpkg.com/prettier@2.8.8/parser-yaml.js"></script>
    <script src="https://unpkg.com/prettier@2.8.8/parser-graphql.js"></script>
@endpush

@section('content')
<div class="max-w-4xl mx-auto w-full bg-white dark:bg-slate-900 p-6 md:p-10 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 mt-4 md:mt-8 transition-colors">
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">What are we saving today?</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm">Drop your code, text, or configuration files below.</p>
    </div>

    <form action="{{ route('pastes.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <input type="text" name="title" value="{{ old('title') }}"
                class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 font-semibold text-lg text-slate-800 dark:text-white focus:bg-white dark:focus:bg-slate-800 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder:font-normal placeholder:text-slate-400 dark:placeholder:text-slate-500 @error('title') border-rose-500 focus:ring-rose-500/20 @enderror"
                placeholder="Title (Optional)...">

            @error('title')
                <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="mb-6" x-data="{
            content: @js(old('content', '')),
            wrapText: false,
            indentSize: '4', // Default to 4 spaces
            isFormatting: false,
            get lineCount() {
                return this.content.split('\n').length || 1;
            },
            syncScroll(e) {
                if(this.$refs.lineNumbers) {
                    this.$refs.lineNumbers.scrollTop = e.target.scrollTop;
                }
            },
            resize() {
                if (!this.$refs.textarea) return;
                this.$refs.textarea.style.height = 'auto';
                this.$refs.textarea.style.height = this.$refs.textarea.scrollHeight + 'px';
            },
            insertTab(e) {
                const start = e.target.selectionStart;
                const end = e.target.selectionEnd;
                const tabCharacter = this.indentSize === 'tab' ? '\t' : ' '.repeat(parseInt(this.indentSize));
                this.content = this.content.substring(0, start) + tabCharacter + this.content.substring(end);
                $nextTick(() => {
                    e.target.selectionStart = e.target.selectionEnd = start + tabCharacter.length;
                    this.resize();
                });
            },
            formatCode() {
                if (!this.content || this.content.trim() === '') return;
                this.isFormatting = true;

                setTimeout(() => {
                    // Check if dark mode is active
                    const isDark = document.documentElement.classList.contains('dark');
                    const swalTheme = {
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        background: isDark ? '#1e293b' : '#ffffff',
                        color: isDark ? '#f8fafc' : '#0f172a'
                    };

                    try {
                        const syntax = document.querySelector('input[name=&quot;syntax&quot;]').value;

                        // Map syntaxes to Prettier parsers
                        const parserMap = {
                            'javascript': 'babel',
                            'typescript': 'babel-ts',
                            'json': 'json',
                            'html': 'html',
                            'xml': 'html',
                            'css': 'css',
                            'scss': 'scss',
                            'less': 'less',
                            'markdown': 'markdown',
                            'yaml': 'yaml',
                            'graphql': 'graphql'
                        };

                        const parser = parserMap[syntax];

                        if (parser && typeof prettier !== 'undefined') {
                            // Full Prettier Formatting
                            this.content = prettier.format(this.content, {
                                parser: parser,
                                plugins: prettierPlugins,
                                tabWidth: parseInt(this.indentSize === 'tab' ? 4 : this.indentSize),
                                useTabs: this.indentSize === 'tab'
                            });

                            Swal.fire({
                                ...swalTheme,
                                icon: 'success',
                                iconColor: '#10b981',
                                title: 'Code formatted!',
                                timer: 2000
                            });
                        } else {
                            // Basic Fallback Cleanup for C++, Python, Bash, etc.
                            this.content = this.content.split('\n').map(line => line.trimEnd()).join('\n');

                            Swal.fire({
                                ...swalTheme,
                                icon: 'info',
                                title: `Basic cleanup applied. Full formatting isn't supported for ${syntax.toUpperCase()} in the browser.`,
                                timer: 4000
                            });
                        }

                        this.$nextTick(() => this.resize());
                    } catch (err) {
                        console.error('Format error:', err);
                        Swal.fire({
                            ...swalTheme,
                            icon: 'error',
                            title: 'Syntax error: Could not format code.',
                            timer: 3000
                        });
                    } finally {
                        this.isFormatting = false;
                    }
                }, 100);
            }
        }"
        x-init="$nextTick(() => resize()); $watch('wrapText', () => $nextTick(() => resize()))">

            <div class="flex justify-end items-center mb-2 px-1">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5">
                        <div x-data="{
                            open: false,
                            dropUp: false,
                            options: {
                                '2': '2 spaces',
                                '4': '4 spaces',
                                '8': '8 spaces',
                                'tab': 'Tab'
                            },
                            get selectedLabel() { return this.options[indentSize]; },
                            reposition() {
                                if (!this.$refs.button) return;
                                const rect = this.$refs.button.getBoundingClientRect();
                                const spaceBelow = window.innerHeight - rect.bottom;
                                this.dropUp = spaceBelow < 200 && rect.top > spaceBelow;
                            }
                        }"
                        @click.away="open = false"
                        @scroll.window="open ? reposition() : null"
                        @resize.window="open ? reposition() : null"
                        class="relative">
                            <button x-ref="button" @click="open = !open; if(open) $nextTick(() => reposition())" type="button"
                                    class="flex items-center justify-between min-w-[5.5rem] bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md py-1.5 px-2.5 focus:ring-0 cursor-pointer outline-none transition-colors text-xs font-semibold">
                                <span x-text="selectedLabel"></span>
                                <svg class="w-3.5 h-3.5 ml-1.5 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <ul x-show="open" x-transition.opacity.duration.200ms
                                :class="dropUp ? 'bottom-full mb-1' : 'top-full mt-1'"
                                class="absolute right-0 z-50 w-32 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl py-1 text-xs" style="display: none;">
                                <template x-for="(label, key) in options" :key="key">
                                    <li @click="indentSize = key; open = false"
                                        class="px-3 py-2 cursor-pointer transition-colors"
                                        :class="indentSize === key ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400'">
                                        <span x-text="label"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <button type="button" @click="formatCode" :disabled="isFormatting"
                            class="text-xs font-semibold px-3 py-1.5 rounded-md flex items-center gap-1.5 transition-colors bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg x-show="!isFormatting" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        <svg x-show="isFormatting" class="w-3.5 h-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-text="isFormatting ? 'Formatting...' : 'Prettify'"></span>
                    </button>

                    <button type="button" @click="wrapText = !wrapText"
                            class="text-xs font-semibold px-3 py-1.5 rounded-md flex items-center gap-1.5 transition-colors"
                            :class="wrapText ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        <span x-text="wrapText ? 'Unwrap' : 'Wrap'"></span>
                    </button>
                </div>
            </div>

            <div class="relative flex w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden focus-within:ring-4 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 focus-within:bg-white dark:focus-within:bg-slate-800 transition-all @error('content') border-rose-500 focus-within:ring-rose-500/20 @enderror">

                <div x-show="!wrapText"
                     x-ref="lineNumbers"
                     class="w-12 flex-shrink-0 text-right pr-3 py-5 font-mono text-sm text-slate-400 dark:text-slate-500 bg-slate-100/50 dark:bg-slate-800/50 border-r border-slate-200 dark:border-slate-700 select-none overflow-hidden"
                     style="pointer-events: none; display: none;">
                    <template x-for="i in lineCount" :key="i">
                        <div x-text="i" class="leading-normal h-[21px]"></div>
                    </template>
                </div>

                <textarea name="content" x-ref="textarea" x-model="content" rows="14"
                    @keydown.tab.prevent="insertTab($event)"
                    @scroll="syncScroll" @input="syncScroll; resize()"
                    class="w-full bg-transparent p-5 font-mono text-sm text-slate-800 dark:text-slate-200 outline-none resize-none overflow-y-hidden placeholder:text-slate-400 dark:placeholder:text-slate-500 leading-normal"
                    :class="wrapText ? 'whitespace-pre-wrap' : 'whitespace-pre overflow-x-auto'"
                    placeholder="Paste your brilliant code or text here..." required></textarea>
            </div>

            @error('content')
                <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-slate-50/50 dark:bg-slate-800/30 p-6 rounded-xl border border-slate-100 dark:border-slate-700/50">

            <div x-data="{
                open: false,
                dropUp: false,
                value: '{{ old('syntax', 'plaintext') }}',
                options: {
                    'plaintext': 'None (Plain Text)',
                    'bash': 'Bash / Shell',
                    'c': 'C',
                    'cpp': 'C++',
                    'csharp': 'C#',
                    'css': 'CSS',
                    'dart': 'Dart',
                    'diff': 'Diff',
                    'docker': 'Docker',
                    'go': 'Go',
                    'graphql': 'GraphQL',
                    'html': 'HTML',
                    'java': 'Java',
                    'javascript': 'JavaScript',
                    'json': 'JSON',
                    'kotlin': 'Kotlin',
                    'latex': 'LaTeX',
                    'less': 'Less',
                    'lua': 'Lua',
                    'markdown': 'Markdown',
                    'nginx': 'Nginx',
                    'objectivec': 'Objective-C',
                    'perl': 'Perl',
                    'php': 'PHP',
                    'powershell': 'PowerShell',
                    'python': 'Python',
                    'r': 'R',
                    'ruby': 'Ruby',
                    'rust': 'Rust',
                    'sass': 'Sass (Sass)',
                    'scss': 'Sass (Scss)',
                    'scala': 'Scala',
                    'sql': 'SQL',
                    'swift': 'Swift',
                    'typescript': 'TypeScript',
                    'xml': 'XML',
                    'yaml': 'YAML'
                },
                get selectedLabel() { return this.options[this.value]; },
                reposition() {
                    if (!this.$refs.button) return;
                    const rect = this.$refs.button.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    this.dropUp = spaceBelow < 260 && rect.top > spaceBelow;
                }
            }"
            @click.away="open = false"
            @scroll.window="open ? reposition() : null"
            @resize.window="open ? reposition() : null">
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Syntax</label>
                <input type="hidden" name="syntax" x-model="value">
                <div class="relative">
                    <button x-ref="button" @click="open = !open; if(open) $nextTick(() => reposition())" type="button" class="w-full flex items-center justify-between bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition shadow-sm">
                        <span x-text="selectedLabel"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="open" x-transition.opacity.duration.200ms
                        :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'"
                        class="absolute z-50 w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto py-1 text-sm" style="display: none;">
                        <template x-for="(label, key) in options" :key="key">
                            <li @click="value = key; open = false"
                                class="px-4 py-2.5 cursor-pointer transition-colors"
                                :class="value === key ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400'">
                                <span x-text="label"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div x-data="{
                open: false,
                dropUp: false,
                value: '{{ old('visibility', 'public') }}',
                options: [
                    { id: 'public', label: '🌍 Public', disabled: false },
                    { id: 'unlisted', label: '🔗 Unlisted', disabled: false },
                    { id: 'private', label: '🔒 Private', disabled: {{ !auth()->check() ? 'true' : 'false' }} }
                ],
                get selectedLabel() { return this.options.find(o => o.id === this.value).label; },
                reposition() {
                    if (!this.$refs.button) return;
                    const rect = this.$refs.button.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    this.dropUp = spaceBelow < 260 && rect.top > spaceBelow;
                }
            }"
            @click.away="open = false"
            @scroll.window="open ? reposition() : null"
            @resize.window="open ? reposition() : null">
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Visibility</label>
                <input type="hidden" name="visibility" x-model="value">
                <div class="relative">
                    <button x-ref="button" @click="open = !open; if(open) $nextTick(() => reposition())" type="button" class="w-full flex items-center justify-between bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition shadow-sm @error('visibility') border-rose-500 ring-4 ring-rose-500/20 @enderror">
                        <span x-text="selectedLabel"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="open" x-transition.opacity.duration.200ms
                        :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'"
                        class="absolute z-50 w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto py-1 text-sm" style="display: none;">
                        <template x-for="option in options" :key="option.id">
                            <li @click="if(!option.disabled) { value = option.id; open = false }"
                                class="px-4 py-2.5 transition-colors"
                                :class="{
                                    'opacity-50 cursor-not-allowed text-slate-400 dark:text-slate-500': option.disabled,
                                    'cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400': !option.disabled,
                                    'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': value === option.id && !option.disabled,
                                    'text-slate-700 dark:text-slate-300': value !== option.id && !option.disabled
                                }">
                                <span x-text="option.label"></span>
                            </li>
                        </template>
                    </ul>
                </div>
                @error('visibility')
                    <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Password (Optional)</label>
                <input type="password" name="password" placeholder="Keep it secret..."
                    class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 placeholder:text-slate-400 dark:placeholder:text-slate-500 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition shadow-sm @error('password') border-rose-500 focus:ring-rose-500/20 @enderror">

                @error('password')
                    <p class="text-rose-500 dark:text-rose-400 text-sm mt-2 font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div x-data="{
                open: false,
                dropUp: false,
                value: '{{ old('expiration_minutes', '') }}',
                options: {
                    '': 'Never',
                    '10': '10 Minutes',
                    '60': '1 Hour',
                    '1440': '1 Day',
                    '10080': '1 Week',
                    '20160': '2 Weeks',
                    '43200': '1 Month',
                    '259200': '6 Months',
                    '525600': '1 Year'
                },
                get selectedLabel() { return this.options[this.value]; },
                reposition() {
                    if (!this.$refs.button) return;
                    const rect = this.$refs.button.getBoundingClientRect();
                    const spaceBelow = window.innerHeight - rect.bottom;
                    this.dropUp = spaceBelow < 260 && rect.top > spaceBelow;
                }
            }"
            @click.away="open = false"
            @scroll.window="open ? reposition() : null"
            @resize.window="open ? reposition() : null">
                <label class="block font-semibold text-sm text-slate-700 dark:text-slate-300 mb-2">Expiration</label>
                <input type="hidden" name="expiration_minutes" x-model="value">
                <div class="relative">
                    <button x-ref="button" @click="open = !open; if(open) $nextTick(() => reposition())" type="button" class="w-full flex items-center justify-between bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 p-3 rounded-lg focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none text-sm transition shadow-sm">
                        <span x-text="selectedLabel"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="open" x-transition.opacity.duration.200ms
                        :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'"
                        class="absolute z-50 w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl max-h-60 overflow-y-auto py-1 text-sm" style="display: none;">
                        <template x-for="(label, key) in options" :key="key">
                            <li @click="value = key; open = false"
                                class="px-4 py-2.5 cursor-pointer transition-colors"
                                :class="value === key ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400'">
                                <span x-text="label"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

        </div>

        <div class="mt-8 flex flex-col md:flex-row items-center justify-end gap-4">
            <button type="submit" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl transition-all shadow-md shadow-indigo-500/30 dark:shadow-indigo-900/40 hover:shadow-lg transform hover:-translate-y-0.5">
                Save & Share Paste
            </button>
        </div>
    </form>
</div>
@endsection
