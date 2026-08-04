<?php

namespace App\NativeComponents;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Edge\NativeComponent;
use Throwable;

class Home extends NativeComponent
{
    /** @var list<array{id: int, title: string, short_description?: string, github_url?: string}> */
    public array $packages = [];

    public ?string $errorMessage = null;

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->errorMessage = null;

        try {
            $packages = Http::connectTimeout(3)
                ->timeout(5)
                ->get(Config::string('app.api_url').'/packages')
                ->throw()
                ->json('data', []);

            $this->packages = is_array($packages) ? array_values($packages) : [];
        } catch (Throwable) {
            $this->packages = [];
            $this->errorMessage = 'Packages could not be loaded. Check your connection and try again.';
        }
    }

    public function openPackage(int $packageId): void
    {
        $this->navigate($this->route('packages.show', ['package' => $packageId]));
    }
}
