<?php

use App\NativeComponents\Discover;
use App\NativeComponents\Home;
use App\NativeComponents\PackageDetails;
use App\NativeLayouts\StackLayout;
use App\NativeLayouts\TabsLayout;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Edge\NativeRouter;
use Native\Mobile\Testing\Native;

test('native routes preserve the existing URIs names and layouts', function () {
    expect(route('home', absolute: false))->toBe('/')
        ->and(route('discover', absolute: false))->toBe('/discover')
        ->and(route('packages.show', ['package' => 1], absolute: false))->toBe('/packages/1')
        ->and(NativeRouter::resolve('/'))->toMatchArray([
            'class' => Home::class,
            'layout' => TabsLayout::class,
        ])
        ->and(NativeRouter::resolve('/packages/1'))->toMatchArray([
            'class' => PackageDetails::class,
            'layout' => StackLayout::class,
        ])
        ->and(NativeRouter::resolve('/discover'))->toMatchArray([
            'class' => Discover::class,
            'layout' => TabsLayout::class,
        ]);
});

test('home layout renders the primary bottom navigation', function () {
    Http::fake([
        '*' => Http::response(['data' => []]),
    ]);

    Native::visit('/')
        ->assertHasTabBar()
        ->assertHasTab('Home')
        ->assertHasTab('Discover')
        ->assertTabActive('Home')
        ->assertTabBarVisible();
});

test('discover layout renders the active discover tab', function () {
    Native::visit('/discover')
        ->assertHasTabBar()
        ->assertHasTab('Home')
        ->assertHasTab('Discover')
        ->assertTabActive('Discover')
        ->assertTabBarVisible();
});
