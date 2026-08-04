<?php

use App\NativeComponents\Home;
use App\NativeComponents\PackageRow;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Testing\Native;

test('it renders packages from the API and opens a package', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages' => Http::response([
            'data' => [[
                'id' => 1,
                'title' => 'laravel/framework',
                'short_description' => 'The Laravel Framework.',
                'github_url' => 'https://github.com/laravel/framework',
                'stars' => 34_567,
            ]],
        ]),
    ]);

    Native::visit('/')
        ->assertScreen(Home::class)
        ->assertElement('image', fn (array $node): bool => str_ends_with($node['props']['src'] ?? '', '/public/app-logo.png'))
        ->assertElement('image', fn (array $node): bool => ($node['props']['alt'] ?? null) === config('app.name'))
        ->assertSee('laravel/framework')
        ->assertSee('The Laravel Framework.')
        ->assertSee('34,567')
        ->assertAccessible()
        ->tap('package-row-1')
        ->assertNavigatedTo('/packages/1');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://packages.example/api/packages');
});

test('package rows show a centered star count', function () {
    Native::test(PackageRow::class)
        ->set('package', [
            'id' => 1,
            'title' => 'laravel/framework',
            'short_description' => 'The Laravel Framework.',
            'stars' => 34_567,
        ])
        ->assertSee('34,567')
        ->assertElement('column', fn (array $node): bool => ($node['layout']['width'] ?? null) === 48.0
            && ($node['layout']['align_items'] ?? null) === 1
            && ($node['layout']['justify_content'] ?? null) === 1)
        ->assertElement('icon', fn (array $node): bool => ($node['props']['name'] ?? null) === 'star')
        ->assertAccessible();
});

test('it shows an empty state', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages' => Http::response(['data' => []]),
    ]);

    Native::visit('/')
        ->assertSee('No packages yet')
        ->assertAccessible();
});

test('it recovers from an API failure', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fakeSequence('packages.example/api/packages')
        ->pushStatus(503)
        ->push([
            'data' => [[
                'id' => 2,
                'title' => 'nativephp/mobile',
                'short_description' => 'Build native apps with Laravel.',
                'stars' => 812,
            ]],
        ]);

    Native::visit('/')
        ->assertSee('Unable to load packages')
        ->tap('retry-packages')
        ->assertSee('nativephp/mobile')
        ->assertSet('errorMessage', null);
});
