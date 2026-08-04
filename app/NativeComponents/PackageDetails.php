<?php

namespace App\NativeComponents;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Edge\NativeComponent;
use Throwable;
use UnexpectedValueException;

class PackageDetails extends NativeComponent
{
    /** @var array{id: int, title: string, short_description: string, github_url: string, stars: int, latest_version: string, latest_release_date: string, images: list<string>}|null */
    public ?array $package = null;

    public ?string $errorMessage = null;

    public ?int $selectedScreenshot = null;

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        $this->errorMessage = null;
        $this->selectedScreenshot = null;

        try {
            $packageId = (string) $this->param('package');

            if ($packageId === '' || ! ctype_digit($packageId)) {
                throw new UnexpectedValueException('The package ID is invalid.');
            }

            $package = Http::connectTimeout(3)
                ->timeout(5)
                ->get(Config::string('app.api_url').'/packages/'.$packageId)
                ->throw()
                ->json('data');

            if (! is_array($package)) {
                throw new UnexpectedValueException('The package response is invalid.');
            }

            $this->package = [
                'id' => (int) ($package['id'] ?? $packageId),
                'title' => (string) ($package['title'] ?? 'Package'),
                'short_description' => (string) ($package['short_description'] ?? ''),
                'github_url' => (string) ($package['github_url'] ?? ''),
                'stars' => (int) ($package['stars'] ?? 0),
                'latest_version' => (string) ($package['latest_version'] ?? ''),
                'latest_release_date' => (string) ($package['latest_release_date'] ?? ''),
                'images' => $this->normalizeImages($package['images'] ?? []),
            ];
        } catch (Throwable) {
            $this->package = null;
            $this->errorMessage = 'Package details could not be loaded. Check your connection and try again.';
        }
    }

    public function openGithub(): void
    {
        $githubUrl = $this->package['github_url'] ?? '';

        if ($githubUrl !== '') {
            $this->exitToWeb($githubUrl);
        }
    }

    public function openScreenshot(int $index): void
    {
        if (array_key_exists($index, $this->package['images'] ?? [])) {
            $this->selectedScreenshot = $index;
        }
    }

    public function closeScreenshot(): void
    {
        $this->selectedScreenshot = null;
    }

    public function swipeScreenshot(string $direction): void
    {
        $imageCount = count($this->package['images'] ?? []);

        if ($this->selectedScreenshot === null || $imageCount < 2) {
            return;
        }

        if ($direction === 'left') {
            $this->selectedScreenshot = ($this->selectedScreenshot + 1) % $imageCount;
        }

        if ($direction === 'right') {
            $this->selectedScreenshot = ($this->selectedScreenshot - 1 + $imageCount) % $imageCount;
        }
    }

    public function navTitle(): string
    {
        return $this->package['title'] ?? 'Package Details';
    }

    /**
     * @return list<string>
     */
    private function normalizeImages(mixed $images): array
    {
        if (! is_array($images)) {
            return [];
        }

        $urls = [];

        foreach ($images as $image) {
            $url = is_string($image)
                ? $image
                : (is_array($image) ? ($image['url'] ?? $image['image_url'] ?? null) : null);

            if (is_string($url) && $url !== '') {
                $urls[] = $url;
            }
        }

        return $urls;
    }
}
