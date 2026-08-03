<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

test('returns a successful response', function () {
    config(['app.api_url' => 'https://packages.example/api']);

    Http::preventStrayRequests();
    Http::fake([
        'packages.example/api/packages' => Http::response([
            'data' => [[
                'title' => 'laravel/framework',
                'short_description' => 'The Laravel Framework.',
                'github_url' => 'https://github.com/laravel/framework',
            ]],
        ]),
    ]);

    $response = $this->get('/');

    $response->assertOk()
        ->assertSeeText('laravel/framework')
        ->assertSeeText('The Laravel Framework.')
        ->assertSee('https://github.com/laravel/framework');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://packages.example/api/packages');
});

test('shows the hard-coded package details', function () {
    $this->get(route('packages.show'))
        ->assertOk()
        ->assertSeeText('AnySearch')
        ->assertSeeText('Real-time structured search trusted by agents and developers')
        ->assertSee('https://github.com');
});

test('shows the screenshot lightbox controls', function () {
    $this->get(route('packages.show'))
        ->assertOk()
        ->assertSee('aria-label="Open AnySearch screenshot 1"', false)
        ->assertSee('x-trap.inert.noscroll="open"', false)
        ->assertSee('@keydown.right.window="open && goTo(active + 1)"', false);
});
