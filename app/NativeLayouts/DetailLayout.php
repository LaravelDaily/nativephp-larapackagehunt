<?php

namespace App\NativeLayouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

class DetailLayout extends NativeLayout
{
    protected ?string $font = 'semibold';

    public function navBar(NativeComponent $screen): NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle())
            ->back()
            ->displayMode('inline');
    }

    public function usesNativeChrome(): bool
    {
        return true;
    }
}
