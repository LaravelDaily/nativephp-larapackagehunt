<?php

namespace App\NativeLayouts;

use Native\Mobile\Edge\Layouts\Builders\NavBar;
use Native\Mobile\Edge\Layouts\Builders\Tab;
use Native\Mobile\Edge\Layouts\Builders\TabBar;
use Native\Mobile\Edge\Layouts\NativeLayout;
use Native\Mobile\Edge\NativeComponent;

class TabsLayout extends NativeLayout
{
    protected ?string $font = 'semibold';

    public function navBar(NativeComponent $screen): NavBar
    {
        return NavBar::make()
            ->title($screen->navTitle())
            ->displayMode('large');
    }

    public function tabBar(NativeComponent $screen): TabBar
    {
        return TabBar::make()
            ->labelVisibility('labeled')
            ->add(Tab::link('Home', route('home', absolute: false), icon: 'home')->id('home'))
            ->add(Tab::action('Discover', icon: 'search')->id('discover'));
    }

    public function usesNativeChrome(): bool
    {
        return true;
    }
}
