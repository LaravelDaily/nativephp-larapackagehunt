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
