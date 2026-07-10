<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel Package Hunt') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="nativephp-safe-area min-h-screen bg-white font-sans text-slate-900 antialiased">
        <main class="mx-auto min-h-screen w-full max-w-md overflow-hidden bg-white pb-28">
            <div class="flex justify-center px-7 pt-7 pb-6">
                <x-app-logo class="size-14" />
            </div>

            <section class="mx-7 rounded-2xl border border-slate-100 bg-white px-7 pt-7 shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
                <h1 class="text-3xl font-bold tracking-normal text-slate-800">
                    Latest <span class="text-slate-500">Packages</span>
                </h1>

                <div class="mt-8 divide-y divide-slate-200">
                    @foreach ($packages as $package)
                        <x-package-list-item :package="$package" />
                    @endforeach
                </div>
            </section>
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
