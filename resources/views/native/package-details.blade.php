@use('App\Icons\Android')
@use('App\Icons\Ios')

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
    <native:stack class="w-full h-full">
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

                @if (! empty($package['images']))
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
                                    :width="280"
                                    :height="176"
                                    :fit="2"
                                    class="rounded-2xl"
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
                    <native:column class="gap-1">
                        <native:text font="medium" class="text-sm font-medium text-theme-on-surface-variant">Stars</native:text>
                        <native:text font="bold" class="text-lg font-bold text-theme-on-surface">
                            {{ number_format($package['stars']) }}
                        </native:text>
                    </native:column>
                </native:column>
            </native:column>
        </native:scroll-view>

        @if ($selectedScreenshot !== null)
            <native:column
                ref="screenshot-overlay"
                class="w-full h-full items-center justify-center gap-5 bg-theme-gallery-background/78 glass:clear p-4"
            >
                <native:gesture-area
                    ref="screenshot-swipe-area"
                    class="w-full h-[420] items-center justify-center"
                    a11y-label="{{ $package['title'] }} screenshot {{ $selectedScreenshot + 1 }}"
                    a11y-hint="Swipe left or right to view another screenshot"
                    @swipe="swipeScreenshot"
                >
                    <native:image
                        native:key="gallery-image-{{ $selectedScreenshot + 1 }}"
                        :src="$package['images'][$selectedScreenshot]"
                        :fit="1"
                        class="w-full h-full rounded-xl"
                        alt="{{ $package['title'] }} screenshot {{ $selectedScreenshot + 1 }}"
                    />
                </native:gesture-area>

                @if (count($package['images']) > 1)
                    <native:row class="w-full items-center justify-center gap-2">
                        @foreach ($package['images'] as $dotIndex => $unusedImage)
                            <native:circle
                                ref="gallery-dot-{{ $dotIndex + 1 }}"
                                :width="$dotIndex === $selectedScreenshot ? 10 : 8"
                                :height="$dotIndex === $selectedScreenshot ? 10 : 8"
                                :class="$dotIndex === $selectedScreenshot
                                    ? 'bg-theme-primary'
                                    : 'bg-theme-gallery-indicator-inactive'"
                            />
                        @endforeach
                    </native:row>
                @endif

                <native:pressable
                    ref="close-screenshot"
                    class="absolute top-[16] left-[16] w-11 h-11 items-center justify-center"
                    a11y-label="Close screenshot gallery"
                    :press-opacity="0.65"
                    :press-scale="0.96"
                    @tap="closeScreenshot"
                >
                    <native:icon
                        :ios="Ios::Xmark"
                        :android="Android::Close"
                        :size="24"
                        class="text-theme-on-gallery"
                    />
                </native:pressable>
            </native:column>
        @endif
    </native:stack>
@endif
