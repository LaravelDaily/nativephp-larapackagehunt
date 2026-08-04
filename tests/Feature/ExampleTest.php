<?php

use App\NativeComponents\Home;
use App\NativeComponents\PackageDetails;
use App\NativeLayouts\StackLayout;
use App\NativeLayouts\TabsLayout;
use Illuminate\Support\Facades\Http;
use Native\Mobile\Edge\NativeRouter;
use Native\Mobile\Testing\Native;

test('native routes preserve the existing URIs names and layouts', function () {
    expect(route('home', absolute: false))->toBe('/')
        ->and(route('packages.show', absolute: false))->toBe('/packages/anysearch')
        ->and(NativeRouter::resolve('/'))->toMatchArray([
            'class' => Home::class,
            'layout' => TabsLayout::class,
        ])
        ->and(NativeRouter::resolve('/packages/anysearch'))->toMatchArray([
            'class' => PackageDetails::class,
            'layout' => StackLayout::class,
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
