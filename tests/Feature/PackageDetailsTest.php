<?php

use App\NativeComponents\PackageDetails;
use Native\Mobile\Testing\Native;

test('it renders package details and opens GitHub', function () {
    Native::visit('/packages/anysearch')
        ->assertScreen(PackageDetails::class)
        ->assertNavTitle('AnySearch')
        ->assertSee('Real-time structured search trusted by agents and developers')
        ->assertSee('July 10, 2026')
        ->assertSee('v1.0.0')
        ->assertAccessible()
        ->tap('open-github')
        ->assertExitedToWeb('https://github.com');
});

test('it opens and dismisses a screenshot modal', function () {
    Native::visit('/packages/anysearch')
        ->tap('screenshot-1')
        ->assertSet('selectedScreenshot', 0)
        ->assertSee('AnySearch screenshot 1')
        ->dismissSheet('screenshot-modal')
        ->assertSet('selectedScreenshot', null);
});
