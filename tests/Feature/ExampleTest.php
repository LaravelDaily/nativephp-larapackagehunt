<?php

test('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee(route('packages.show'));
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
