@props([
    'package',
])

<a href="{{ route('packages.show') }}" class="block py-6 transition-transform duration-150 ease-out active:scale-[0.96]">
    <div class="min-w-0">
        <h2 class="text-[1.55rem] leading-tight font-bold tracking-normal text-slate-800">
            {{ $package['name'] }}
        </h2>
        <p class="mt-1 text-lg leading-tight text-slate-500">
            {{ $package['description'] }}
        </p>
    </div>
</a>
