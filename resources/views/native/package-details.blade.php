@use('App\Icons\Android')
@use('App\Icons\Ios')

<native:scroll-view class="w-full h-full bg-theme-background">
    <native:column class="w-full p-7 gap-6">
        <native:column class="w-full gap-2">
            <native:text font="bold" class="text-3xl font-bold text-theme-on-background">
                AnySearch
            </native:text>
            <native:text class="text-lg text-theme-on-surface-variant">
                Real-time structured search trusted by agents and developers
            </native:text>
        </native:column>

        <native:button
            ref="open-github"
            label="Open GitHub"
            font="semibold"
            @tap="openGithub"
        />

        <native:divider class="bg-theme-outline-variant" />

        <native:carousel variant="cards" item-width="280" item-spacing="16" a11y-label="Package screenshots">
            @foreach ($screenshots as $index => $screenshot)
                <native:pressable
                    ref="screenshot-{{ $index + 1 }}"
                    native:key="screenshot-{{ $index + 1 }}"
                    class="w-72 h-44 rounded-2xl bg-theme-surface-variant p-5"
                    @tap="openScreenshot({{ $index }})"
                >
                    <native:column class="w-full h-full items-center justify-center gap-3">
                        <native:icon
                            :ios="Ios::Photo"
                            :android="Android::Image"
                            :size="32"
                            class="text-theme-secondary"
                        />
                        <native:text font="medium" class="text-sm font-medium text-center text-theme-on-surface-variant">
                            {{ $screenshot }}
                        </native:text>
                    </native:column>
                </native:pressable>
            @endforeach
        </native:carousel>

        <native:text class="text-lg text-theme-on-surface">
            A search tool for agents, not a search box. AnySearch gives agents filtered, de-duplicated, structured information from trusted sources searched in parallel, helping them produce more reliable results. Free to start.
        </native:text>

        <native:column class="w-full gap-5 rounded-2xl border border-theme-outline-variant bg-theme-surface p-5">
            <native:column class="gap-1">
                <native:text font="medium" class="text-sm font-medium text-theme-on-surface-variant">Author</native:text>
                <native:text font="bold" class="text-lg font-bold text-theme-on-surface">AnySearch</native:text>
            </native:column>
            <native:column class="gap-1">
                <native:text font="medium" class="text-sm font-medium text-theme-on-surface-variant">Latest release</native:text>
                <native:text font="bold" class="text-lg font-bold text-theme-on-surface">July 10, 2026</native:text>
            </native:column>
            <native:column class="gap-1">
                <native:text font="medium" class="text-sm font-medium text-theme-on-surface-variant">Version</native:text>
                <native:text font="bold" class="text-lg font-bold text-theme-on-surface">v1.0.0</native:text>
            </native:column>
        </native:column>
    </native:column>
</native:scroll-view>

@if ($selectedScreenshot !== null)
    <native:modal
        ref="screenshot-modal"
        :visible="true"
        dismissible
        a11y-label="{{ $screenshots[$selectedScreenshot] }}"
        @dismiss="closeScreenshot"
    >
        <native:column class="w-full h-full items-center justify-center gap-6 bg-theme-surface p-7">
            <native:icon
                :ios="Ios::Photo"
                :android="Android::Image"
                :size="64"
                class="text-theme-secondary"
            />
            <native:text font="semibold" class="text-xl font-semibold text-center text-theme-on-surface">
                {{ $screenshots[$selectedScreenshot] }}
            </native:text>
            <native:button ref="close-screenshot" label="Close" variant="secondary" font="semibold" @tap="closeScreenshot" />
        </native:column>
    </native:modal>
@endif
