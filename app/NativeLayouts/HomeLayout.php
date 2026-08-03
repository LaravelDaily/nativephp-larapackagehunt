<?php

namespace App\NativeLayouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

class HomeLayout extends NativeLayout
{
    protected ?string $font = 'semibold';

    public function navBar(NativeComponent $screen): NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle())
            ->displayMode('large');
    }

    public function usesNativeChrome(): bool
    {
        return true;
    }
}
