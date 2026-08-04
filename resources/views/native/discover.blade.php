<native:column class="w-full h-full gap-5 bg-theme-background p-7">
    <native:filled-text-input
        ref="package-search"
        class="w-full"
        placeholder="Search packages"
        leading-icon="search"
        font="medium"
        a11y-label="Search packages"
        a11y-hint="Search Laravel packages by name or keyword"
        native:model.debounce.400ms="search"
    />

    <native:scroll-view class="w-full flex-1">
        <native:column class="w-full gap-5 pb-7">
            @if (trim($search) === '')
                <native:column class="w-full gap-2 rounded-2xl bg-theme-surface-variant p-5">
                    <native:text font="semibold" class="text-lg font-semibold text-theme-on-surface">
                        Try searching
                    </native:text>
                    <native:text class="text-base text-theme-on-surface-variant">
                        Find Laravel packages by name or keyword.
                    </native:text>
                </native:column>
            @elseif ($errorMessage !== null)
                <native:column class="w-full gap-4 rounded-2xl border border-theme-outline bg-theme-surface p-5">
                    <native:text font="semibold" class="text-lg font-semibold text-theme-on-surface">
                        Unable to search packages
                    </native:text>
                    <native:text class="text-base text-theme-on-surface-variant">
                        {{ $errorMessage }}
                    </native:text>
                    <native:button ref="retry-search" label="Try again" font="semibold" @tap="retrySearch" />
                </native:column>
            @elseif (empty($packages))
                <native:column class="w-full gap-2 rounded-2xl bg-theme-surface-variant p-5">
                    <native:text font="semibold" class="text-lg font-semibold text-theme-on-surface">
                        No packages found
                    </native:text>
                    <native:text class="text-base text-theme-on-surface-variant">
                        Try another name or keyword.
                    </native:text>
                </native:column>
            @else
                @foreach ($packages as $package)
                    <native:package-row :package="$package" key="package-{{ $package['id'] }}" />
                @endforeach
            @endif
        </native:column>
    </native:scroll-view>
</native:column>
