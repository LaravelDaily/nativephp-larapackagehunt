<?php

use App\NativeComponents\PackageDetails;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Testing\Native;

test('it renders package details and opens GitHub', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages/1' => Http::response([
            'data' => [
                'id' => 1,
                'title' => 'laravel-at/laravel-image-sanitize',
                'short_description' => 'Prevent malicious code execution through uploaded image files.',
                'github_url' => 'https://github.com/laravel-at/laravel-image-sanitize',
                'latest_version' => 'v5.0.0',
                'latest_release_date' => '2026-06-10',
                'images' => [],
            ],
        ]),
    ]);

    Native::visit('/packages/1')
        ->assertScreen(PackageDetails::class)
        ->assertNavTitle('laravel-at/laravel-image-sanitize')
        ->assertSee('Prevent malicious code execution through uploaded image files.')
        ->assertSee('2026-06-10')
        ->assertSee('v5.0.0')
        ->assertAccessible()
        ->tap('open-github')
        ->assertExitedToWeb('https://github.com/laravel-at/laravel-image-sanitize');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://packages.example/api/packages/1');
});

test('it opens and dismisses a screenshot modal', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages/1' => Http::response([
            'data' => [
                'id' => 1,
                'title' => 'laravel-at/laravel-image-sanitize',
                'short_description' => 'Sanitize image uploads.',
                'github_url' => 'https://github.com/laravel-at/laravel-image-sanitize',
                'latest_version' => 'v5.0.0',
                'latest_release_date' => '2026-06-10',
                'images' => ['https://packages.example/images/screenshot.png'],
            ],
        ]),
    ]);

    Native::visit('/packages/1')
        ->tap('screenshot-1')
        ->assertSet('selectedScreenshot', 0)
        ->dismissSheet('screenshot-modal')
        ->assertSet('selectedScreenshot', null);
});

test('it retries after the package API fails', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fakeSequence('packages.example/api/packages/1')
        ->pushStatus(503)
        ->push([
            'data' => [
                'id' => 1,
                'title' => 'laravel-at/laravel-image-sanitize',
                'short_description' => 'Sanitize image uploads.',
                'github_url' => 'https://github.com/laravel-at/laravel-image-sanitize',
                'latest_version' => 'v5.0.0',
                'latest_release_date' => '2026-06-10',
                'images' => [],
            ],
        ]);

    Native::visit('/packages/1')
        ->assertSee('Unable to load package')
        ->tap('retry-package')
        ->assertSee('laravel-at/laravel-image-sanitize')
        ->assertSet('errorMessage', null);
});
