@php
    $screenshots = [
        ['label' => 'AnySearch screenshot 1', 'background' => 'from-slate-50 to-slate-200 text-slate-400'],
        ['label' => 'AnySearch screenshot 2', 'background' => 'from-slate-100 to-slate-300 text-slate-500'],
    ];
@endphp

@extends('layouts.app')

@section('title', 'AnySearch — '.config('app.name', 'Laravel Package Hunt'))

@section('content')
    <div
        x-data="{
            open: false,
            active: 0,
            count: {{ count($screenshots) }},
            show(index) {
                this.open = true;
                this.active = index;
                this.$nextTick(() => this.goTo(index, false));
            },
            close() {
                this.open = false;
            },
            goTo(index, smooth = true) {
                this.active = (index + this.count) % this.count;
                this.$refs.gallery.scrollTo({
                    left: this.$refs.gallery.clientWidth * this.active,
                    behavior: smooth ? 'smooth' : 'auto',
                });
            },
        }"
        @keydown.escape.window="open && close()"
        @keydown.left.window="open && goTo(active - 1)"
        @keydown.right.window="open && goTo(active + 1)"
    >
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

                <div class="-mx-7 mt-7 flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2">
                    @foreach ($screenshots as $index => $screenshot)
                        <button
                            type="button"
                            aria-label="Open {{ $screenshot['label'] }}"
                            aria-haspopup="dialog"
                            @click="show({{ $index }})"
                            class="grid aspect-video w-[85%] shrink-0 snap-center cursor-zoom-in place-items-center rounded-xl bg-gradient-to-br {{ $screenshot['background'] }} outline outline-1 -outline-offset-1 outline-black/10 transition-[scale,box-shadow] duration-150 ease-out first:ml-7 last:mr-7 hover:shadow-lg active:scale-[0.96]"
                        >
                            <span class="flex flex-col items-center gap-2">
                                <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 16 5-5 4 4 3-3 6 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Zm10-12h.01" />
                                </svg>
                                <span class="text-sm font-medium">Screenshot placeholder</span>
                            </span>
                        </button>
                    @endforeach
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

    <div
            x-show="open"
            x-transition:enter="transition-opacity duration-200 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-150 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-trap.inert.noscroll="open"
            @click.self="close()"
            role="dialog"
            aria-modal="true"
            aria-label="Package screenshots"
            class="fixed inset-0 z-[100] bg-slate-950/40 backdrop-blur-md"
            style="display: none;"
        >
            <button
                x-ref="close"
                type="button"
                @click="close()"
                aria-label="Close screenshots"
                class="absolute top-[max(1.5rem,env(safe-area-inset-top))] left-6 z-10 grid size-16 place-items-center rounded-full bg-white/90 text-slate-800 shadow-xl backdrop-blur transition-[scale,background-color] duration-150 ease-out hover:bg-white active:scale-[0.96]"
            >
                <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
                </svg>
            </button>

            <div
                x-ref="gallery"
                @click.self="close()"
                @scroll.debounce.50ms="active = Math.min(count - 1, Math.max(0, Math.round($el.scrollLeft / $el.clientWidth)))"
                class="flex h-full snap-x snap-mandatory overflow-x-auto overscroll-x-contain [scrollbar-width:none] [&::-webkit-scrollbar]:hidden"
            >
                @foreach ($screenshots as $screenshot)
                    <div class="flex min-w-full snap-center items-center justify-center px-7 py-32">
                        <div
                            role="img"
                            aria-label="{{ $screenshot['label'] }}"
                            class="grid aspect-video w-full max-w-4xl place-items-center rounded-xl bg-gradient-to-br {{ $screenshot['background'] }} shadow-2xl outline outline-1 -outline-offset-1 outline-white/10"
                        >
                            <div class="flex flex-col items-center gap-3">
                                <svg class="size-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 16 5-5 4 4 3-3 6 6M5 20h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2Zm10-12h.01" />
                                </svg>
                                <span class="font-medium">Screenshot placeholder</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pointer-events-none absolute inset-x-0 bottom-[max(2rem,env(safe-area-inset-bottom))] flex justify-center gap-3" aria-label="Screenshot pagination">
                @foreach ($screenshots as $index => $screenshot)
                    <button
                        type="button"
                        @click="goTo({{ $index }})"
                        aria-label="Show {{ $screenshot['label'] }}"
                        :aria-current="active === {{ $index }} ? 'true' : 'false'"
                        class="pointer-events-auto grid size-11 place-items-center"
                    >
                        <span
                            class="size-3 rounded-full shadow-sm transition-[scale,background-color] duration-150 ease-out"
                            :class="active === {{ $index }} ? 'scale-125 bg-red-500' : 'bg-white/90'"
                        ></span>
                    </button>
                @endforeach
            </div>

            <span class="sr-only" aria-live="polite" x-text="`Screenshot ${active + 1} of ${count}`"></span>
        </div>
    </div>
@endsection
