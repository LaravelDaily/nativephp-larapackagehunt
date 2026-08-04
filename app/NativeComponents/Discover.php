<?php

namespace App\NativeComponents;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Native\Mobile\Edge\NativeComponent;
use Throwable;

class Discover extends NativeComponent
{
    public string $search = '';

    /** @var list<array{id: int, title: string, short_description?: string, github_url?: string}> */
    public array $packages = [];

    public ?string $errorMessage = null;

    public function updatedSearch(string $search): void
    {
        $searchTerm = Str::of($search)->squish()->toString();

        if ($searchTerm === '') {
            $this->packages = [];
            $this->errorMessage = null;

            return;
        }

        $this->searchPackages($searchTerm);
    }

    public function retrySearch(): void
    {
        $searchTerm = Str::of($this->search)->squish()->toString();

        if ($searchTerm !== '') {
            $this->searchPackages($searchTerm);
        }
    }

    public function render(): View
    {
        return view('native.discover');
    }

    private function searchPackages(string $searchTerm): void
    {
        $this->packages = [];
        $this->errorMessage = null;

        try {
            $packages = Http::connectTimeout(3)
                ->timeout(5)
                ->get(Config::string('app.api_url').'/packages', [
                    'search' => $searchTerm,
                ])
                ->throw()
                ->json('data', []);

            $this->packages = is_array($packages) ? array_values($packages) : [];
        } catch (Throwable) {
            $this->errorMessage = 'Search results could not be loaded. Check your connection and try again.';
        }
    }
}
