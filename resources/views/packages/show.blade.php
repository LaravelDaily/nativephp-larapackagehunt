<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AnySearch — {{ config('app.name', 'Laravel Package Hunt') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="nativephp-safe-area min-h-screen bg-white font-sans text-slate-900 antialiased">
        <main class="mx-auto min-h-screen w-full max-w-md overflow-hidden bg-white pb-28">
            <header class="px-7 pt-7 pb-5">
                <a
                    href="{{ route('home') }}"
                    aria-label="Back to packages"
                    class="grid size-11 place-items-center rounded-full text-slate-800 transition-[background-color,scale] duration-150 ease-out hover:bg-slate-100 active:scale-[0.96]"
                >
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                    </svg>
                </a>
            </header>

            <article class="mx-7 overflow-hidden rounded-2xl bg-white px-7 py-8 shadow-[0_0_0_1px_rgba(0,0,0,0.06),0_20px_60px_rgba(15,23,42,0.08)]">
                <header>
                    <h1 class="text-balance text-3xl leading-tight font-bold tracking-normal text-slate-800">
                        AnySearch
                    </h1>
                    <p class="mt-2 text-pretty text-lg leading-snug text-slate-500">
                        Real-time structured search trusted by agents and developers
                    </p>
                </header>

                <div class="mt-7 border-y border-slate-200 py-3">
                    <a
                        href="https://github.com"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex min-h-11 items-center gap-2 rounded-xl px-3 font-semibold text-slate-700 transition-[background-color,scale] duration-150 ease-out hover:bg-slate-100 active:scale-[0.96]"
                    >
                        <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 .7a11.5 11.5 0 0 0-3.64 22.4c.58.1.79-.25.79-.56v-2.23c-3.22.7-3.9-1.37-3.9-1.37-.53-1.34-1.29-1.7-1.29-1.7-1.05-.72.08-.71.08-.71 1.17.08 1.78 1.2 1.78 1.2 1.04 1.77 2.72 1.26 3.38.96.1-.75.4-1.26.74-1.55-2.57-.3-5.27-1.29-5.27-5.68 0-1.26.45-2.28 1.19-3.09-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.16 1.18a10.9 10.9 0 0 1 5.76 0c2.2-1.49 3.16-1.18 3.16-1.18.63 1.59.23 2.76.11 3.05.74.81 1.19 1.83 1.19 3.09 0 4.4-2.71 5.38-5.29 5.67.42.36.79 1.07.79 2.16v3.2c0 .31.21.67.8.56A11.5 11.5 0 0 0 12 .7Z" />
                        </svg>
                        GitHub
                    </a>
                </div>

                <div class="-mx-7 mt-7 flex gap-4 overflow-x-auto pb-2">
                    <div
                        role="img"
                        aria-label="AnySearch screenshot placeholder"
                        class="ml-7 grid aspect-video w-[85%] shrink-0 place-items-center rounded-xl bg-gradient-to-br from-slate-50 to-slate-200 text-slate-400 outline outline-1 -outline-offset-1 outline-black/10"
                    >
                        <div class="flex flex-col items-center gap-2">
                            <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 16 5-5 4 4 3-3 6 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Zm10-12h.01" />
                            </svg>
                            <span class="text-sm font-medium">Screenshot placeholder</span>
                        </div>
                    </div>
                    <div
                        role="img"
                        aria-label="AnySearch screenshot placeholder"
                        class="mr-7 grid aspect-video w-[85%] shrink-0 place-items-center rounded-xl bg-gradient-to-br from-slate-100 to-slate-300 text-slate-500 outline outline-1 -outline-offset-1 outline-black/10"
                    >
                        <div class="flex flex-col items-center gap-2">
                            <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 16 5-5 4 4 3-3 6 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Zm10-12h.01" />
                            </svg>
                            <span class="text-sm font-medium">Screenshot placeholder</span>
                        </div>
                    </div>
                </div>

                <p class="mt-7 text-pretty text-lg leading-relaxed text-slate-700">
                    A search tool for agents, not a search box. AI agents are only as good as the information they receive. When connected to AnySearch, your agent gets filtered, de-duplicated, and structured information from trusted sources searched in parallel, helping it produce more reliable results. Free to start.
                </p>

                <dl class="mt-7 space-y-5">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Author</dt>
                        <dd class="mt-1 text-lg font-bold text-slate-800">AnySearch</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Latest release</dt>
                        <dd class="mt-1 text-lg font-bold text-slate-800">July 10, 2026</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Version</dt>
                        <dd class="mt-1 text-lg font-bold text-slate-800">v1.0.0</dd>
                    </div>
                </dl>
            </article>
        </main>

        <native:bottom-nav label-visibility="labeled">
            <native:bottom-nav-item
                id="home"
                icon="home"
                label="Home"
                :url="route('home')"
                :active="true"
            />
            <native:bottom-nav-item
                id="discover"
                icon="search"
                label="Discover"
                url="#"
            />
        </native:bottom-nav>
    </body>
</html>
