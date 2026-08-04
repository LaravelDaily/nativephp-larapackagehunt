<?php

namespace App\NativeComponents;

use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;

class PackageRow extends NativeComponent
{
    /** @var array{id: int, title: string, stars: int, short_description?: string, github_url?: string} */
    public array $package = [
        'id' => 0,
        'title' => 'Package',
        'stars' => 0,
    ];

    public function openPackage(): void
    {
        $packageId = $this->package['id'];

        if ($packageId > 0) {
            $this->navigate($this->route('packages.show', ['package' => $packageId]));
        }
    }

    public function render(): View
    {
        return view('native.package-row');
    }
}
