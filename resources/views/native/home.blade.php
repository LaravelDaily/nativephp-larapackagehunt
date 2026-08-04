<native:refreshable class="w-full h-full bg-theme-background" @refresh="refresh">
    <native:column class="w-full p-7 gap-5">
        <native:row class="w-full justify-center">
            <native:image
                :src="public_path('app-logo.png')"
                class="w-12 h-12"
                alt="{{ config('app.name', 'Laravel Package Hunt') }}"
            />
        </native:row>

        <native:text font="bold" class="text-3xl font-bold text-theme-on-surface">
            Latest <native:text class="text-theme-on-surface-variant">Packages</native:text>
        </native:text>

        @if ($errorMessage !== null)
            <native:column class="w-full gap-4 rounded-2xl border border-theme-outline bg-theme-surface p-5">
                <native:text font="semibold" class="text-lg font-semibold text-theme-on-surface">
                    Unable to load packages
                </native:text>
                <native:text class="text-base text-theme-on-surface-variant">
                    {{ $errorMessage }}
                </native:text>
                <native:button ref="retry-packages" label="Try again" font="semibold" @tap="refresh" />
            </native:column>
        @elseif (empty($packages))
            <native:column class="w-full gap-2 rounded-2xl bg-theme-surface-variant p-5">
                <native:text font="semibold" class="text-lg font-semibold text-theme-on-surface">
                    No packages yet
                </native:text>
                <native:text class="text-base text-theme-on-surface-variant">
                    New Laravel packages will appear here.
                </native:text>
            </native:column>
        @else
            @foreach ($packages as $package)
                <native:package-row :package="$package" key="package-{{ $package['id'] }}" />
            @endforeach
        @endif
    </native:column>
</native:refreshable>
