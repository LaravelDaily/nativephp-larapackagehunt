<?php

namespace App\NativeComponents;

use Native\Mobile\Edge\NativeComponent;

class PackageDetails extends NativeComponent
{
    /** @var list<string> */
    public array $screenshots = [
        'AnySearch screenshot 1',
        'AnySearch screenshot 2',
    ];

    public ?int $selectedScreenshot = null;

    public function openGithub(): void
    {
        $this->exitToWeb('https://github.com');
    }

    public function openScreenshot(int $index): void
    {
        if (array_key_exists($index, $this->screenshots)) {
            $this->selectedScreenshot = $index;
        }
    }

    public function closeScreenshot(): void
    {
        $this->selectedScreenshot = null;
    }

    public function navTitle(): string
    {
        return 'AnySearch';
    }
}
