@props([
    'package',
])

<a href="#" class="block py-6">
    <div class="min-w-0">
        <h2 class="text-[1.55rem] leading-tight font-bold tracking-normal text-slate-800">
            {{ $package['name'] }}
        </h2>
        <p class="mt-1 text-lg leading-tight text-slate-500">
            {{ $package['description'] }}
        </p>
    </div>
</a>
