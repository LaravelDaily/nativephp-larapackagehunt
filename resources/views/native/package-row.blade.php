@use('App\Icons\Android')
@use('App\Icons\Ios')

<native:pressable
    ref="package-row-{{ $package['id'] }}"
    class="w-full rounded-2xl border border-theme-outline-variant bg-theme-surface p-5"
    @tap="openPackage"
>
    <native:row class="w-full items-center gap-4">
        <native:column class="flex-1 gap-1">
            <native:text font="bold" class="text-xl font-bold text-theme-on-surface">
                {{ $package['title'] }}
            </native:text>
            <native:text class="text-base text-theme-on-surface-variant">
                {{ $package['short_description'] ?? 'View package details' }}
            </native:text>
        </native:column>
        <native:icon
            :ios="Ios::ChevronRight"
            :android="Android::ChevronRight"
            :size="20"
            class="text-theme-secondary"
        />
    </native:row>
</native:pressable>
