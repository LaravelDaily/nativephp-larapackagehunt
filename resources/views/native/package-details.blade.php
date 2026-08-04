@if ($errorMessage !== null)
    <native:column class="w-full h-full items-center justify-center gap-4 bg-theme-background p-7">
        <native:text font="semibold" class="text-xl font-semibold text-center text-theme-on-surface">
            Unable to load package
        </native:text>
        <native:text class="text-base text-center text-theme-on-surface-variant">
            {{ $errorMessage }}
        </native:text>
        <native:button ref="retry-package" label="Try again" font="semibold" @tap="refresh" />
    </native:column>
@elseif ($package !== null)
    <native:scroll-view class="w-full h-full bg-theme-background">
        <native:column class="w-full p-7 gap-6">
            <native:column class="w-full gap-2">
                <native:text font="bold" class="text-3xl font-bold text-theme-on-background">
                    {{ $package['title'] }}
                </native:text>
                @if ($package['short_description'] !== '')
                    <native:text class="text-lg text-theme-on-surface-variant">
                        {{ $package['short_description'] }}
                    </native:text>
                @endif
            </native:column>

            @if ($package['github_url'] !== '')
                <native:button
                    ref="open-github"
                    label="Open GitHub"
                    font="semibold"
                    @tap="openGithub"
                />
            @endif

            @if ($package['images'] !== [])
                <native:divider class="bg-theme-outline-variant" />

                <native:carousel variant="cards" item-width="280" item-spacing="16" a11y-label="Package screenshots">
                    @foreach ($package['images'] as $index => $image)
                        <native:pressable
                            ref="screenshot-{{ $index + 1 }}"
                            native:key="screenshot-{{ $index + 1 }}"
                            class="w-72 h-44 rounded-2xl bg-theme-surface-variant"
                            @tap="openScreenshot({{ $index }})"
                        >
                            <native:image
                                :src="$image"
                                class="w-full h-full rounded-2xl"
                                alt="{{ $package['title'] }} screenshot {{ $index + 1 }}"
                            />
                        </native:pressable>
                    @endforeach
                </native:carousel>
            @endif

            <native:column class="w-full gap-5 rounded-2xl border border-theme-outline-variant bg-theme-surface p-5">
                @if ($package['latest_release_date'] !== '')
                    <native:column class="gap-1">
                        <native:text font="medium" class="text-sm font-medium text-theme-on-surface-variant">Latest release</native:text>
                        <native:text font="bold" class="text-lg font-bold text-theme-on-surface">{{ $package['latest_release_date'] }}</native:text>
                    </native:column>
                @endif
                @if ($package['latest_version'] !== '')
                    <native:column class="gap-1">
                        <native:text font="medium" class="text-sm font-medium text-theme-on-surface-variant">Version</native:text>
                        <native:text font="bold" class="text-lg font-bold text-theme-on-surface">{{ $package['latest_version'] }}</native:text>
                    </native:column>
                @endif
            </native:column>
        </native:column>
    </native:scroll-view>

    @if ($selectedScreenshot !== null)
        <native:modal
            ref="screenshot-modal"
            :visible="true"
            dismissible
            a11y-label="{{ $package['title'] }} screenshot {{ $selectedScreenshot + 1 }}"
            @dismiss="closeScreenshot"
        >
            <native:column class="w-full h-full items-center justify-center gap-6 bg-theme-surface p-7">
                <native:image
                    :src="$package['images'][$selectedScreenshot]"
                    class="w-full rounded-2xl"
                    alt="{{ $package['title'] }} screenshot {{ $selectedScreenshot + 1 }}"
                />
                <native:button ref="close-screenshot" label="Close" variant="secondary" font="semibold" @tap="closeScreenshot" />
            </native:column>
        </native:modal>
    @endif
@endif
