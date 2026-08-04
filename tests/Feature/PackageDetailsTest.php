<?php

use App\NativeComponents\PackageDetails;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Testing\Native;
use Native\Mobile\Testing\TestableComponent;

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
                'stars' => 12_345,
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
        ->assertSee('Stars')
        ->assertSee('12,345')
        ->assertAccessible()
        ->tap('open-github')
        ->assertExitedToWeb('https://github.com/laravel-at/laravel-image-sanitize');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://packages.example/api/packages/1');
});

test('it opens and dismisses a screenshot overlay', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages/1' => Http::response([
            'data' => [
                'id' => 1,
                'title' => 'laravel-at/laravel-image-sanitize',
                'short_description' => 'Sanitize image uploads.',
                'github_url' => 'https://github.com/laravel-at/laravel-image-sanitize',
                'stars' => 340,
                'latest_version' => 'v5.0.0',
                'latest_release_date' => '2026-06-10',
                'images' => [
                    ['url' => 'https://packages.example/storage/1/screenshot.png'],
                    ['url' => 'https://packages.example/storage/2/screenshot.png'],
                    ['url' => 'https://packages.example/storage/3/screenshot.png'],
                ],
            ],
        ]),
    ]);

    $component = Native::visit('/packages/1')
        ->assertElement('image', fn (array $node): bool => ($node['props']['src'] ?? null) === 'https://packages.example/storage/1/screenshot.png'
            && ($node['props']['fit'] ?? null) === 2
            && ($node['layout']['width'] ?? null) === 280.0
            && ($node['layout']['height'] ?? null) === 176.0)
        ->tap('screenshot-2')
        ->assertSet('selectedScreenshot', 1)
        ->assertAccessible()
        ->assertElement('column', fn (array $node): bool => ($node['ref'] ?? null) === 'screenshot-overlay'
            && ($node['style']['bg_color'] ?? null) === '#C7000000'
            && ($node['props']['glass'] ?? null) === 9)
        ->assertElement('pressable', fn (array $node): bool => ($node['ref'] ?? null) === 'close-screenshot'
            && ($node['layout']['position_type'] ?? null) === 1
            && ($node['layout']['position'] ?? null) === [16.0, 0.0, 0.0, 16.0]
            && ($node['layout']['width'] ?? null) === 44.0
            && ($node['layout']['height'] ?? null) === 44.0
            && ($node['props']['press-opacity'] ?? null) === 0.65
            && ($node['props']['press-scale'] ?? null) === 0.96
            && ! isset($node['style']['bg_color']))
        ->assertElement('gesture_area', fn (array $node): bool => ($node['ref'] ?? null) === 'screenshot-swipe-area'
            && ($node['props']['swipe-fingers'] ?? null) === 1)
        ->assertElement('circle', fn (array $node): bool => ($node['ref'] ?? null) === 'gallery-dot-2'
            && ($node['style']['bg_color'] ?? null) === '#2563EB')
        ->assertElement('circle', fn (array $node): bool => ($node['ref'] ?? null) === 'gallery-dot-1'
            && ($node['style']['bg_color'] ?? null) === '#CBD5E1')
        ->fireEvent('screenshot-swipe-area', TestableComponent::EVENT_TEXT_CHANGE, ['text' => 'left'])
        ->assertSet('selectedScreenshot', 2)
        ->assertElement('circle', fn (array $node): bool => ($node['ref'] ?? null) === 'gallery-dot-3'
            && ($node['style']['bg_color'] ?? null) === '#2563EB')
        ->fireEvent('screenshot-swipe-area', TestableComponent::EVENT_TEXT_CHANGE, ['text' => 'left'])
        ->assertSet('selectedScreenshot', 0)
        ->fireEvent('screenshot-swipe-area', TestableComponent::EVENT_TEXT_CHANGE, ['text' => 'right'])
        ->assertSet('selectedScreenshot', 2);

    $component
        ->tap('close-screenshot')
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
                'stars' => 340,
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
