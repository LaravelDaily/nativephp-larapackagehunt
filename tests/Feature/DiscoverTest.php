<?php

use App\NativeComponents\Discover;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Testing\Native;

test('it prompts for a search without loading packages', function () {
    Http::preventStrayRequests();

    Native::visit('/discover')
        ->assertScreen(Discover::class)
        ->assertElement('filled_text_input', fn (array $node): bool => ($node['ref'] ?? null) === 'package-search'
            && ($node['props']['sync_mode'] ?? null) === 'debounce'
            && ($node['props']['debounce_ms'] ?? null) === 400)
        ->assertSee('Try searching')
        ->assertSee('Find Laravel packages by name or keyword.')
        ->assertAccessible();

    Http::assertNothingSent();
});

test('it searches packages and opens a result', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages*' => Http::response([
            'data' => [[
                'id' => 10,
                'title' => 'nativephp/mobile',
                'short_description' => 'Build native apps with Laravel.',
            ]],
        ]),
    ]);

    Native::visit('/discover')
        ->input('package-search', 'nativephp')
        ->assertSet('search', 'nativephp')
        ->assertSee('nativephp/mobile')
        ->assertSee('Build native apps with Laravel.')
        ->assertAccessible()
        ->tap('package-row-10')
        ->assertNavigatedTo('/packages/10');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://packages.example/api/packages?search=nativephp');
});

test('it shows an empty search state', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages*' => Http::response(['data' => []]),
    ]);

    Native::visit('/discover')
        ->input('package-search', 'missing')
        ->assertSee('No packages found')
        ->assertAccessible();
});

test('it retries after the search API fails', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fakeSequence('packages.example/api/packages*')
        ->pushStatus(503)
        ->push([
            'data' => [[
                'id' => 11,
                'title' => 'laravel/framework',
                'short_description' => 'The Laravel Framework.',
            ]],
        ]);

    Native::visit('/discover')
        ->input('package-search', 'laravel')
        ->assertSee('Unable to search packages')
        ->tap('retry-search')
        ->assertSee('laravel/framework')
        ->assertSet('errorMessage', null);
});
