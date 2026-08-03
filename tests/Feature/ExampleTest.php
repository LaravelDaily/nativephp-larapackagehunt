<?php

use App\NativeComponents\Home;
use App\NativeComponents\PackageDetails;
use App\NativeLayouts\DetailLayout;
use App\NativeLayouts\HomeLayout;
use Native\Mobile\Edge\NativeRouter;

test('native routes preserve the existing URIs names and layouts', function () {
    expect(route('home', absolute: false))->toBe('/')
        ->and(route('packages.show', absolute: false))->toBe('/packages/anysearch')
        ->and(NativeRouter::resolve('/'))->toMatchArray([
            'class' => Home::class,
            'layout' => HomeLayout::class,
        ])
        ->and(NativeRouter::resolve('/packages/anysearch'))->toMatchArray([
            'class' => PackageDetails::class,
            'layout' => DetailLayout::class,
        ]);
});
