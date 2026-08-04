<?php

use App\NativeComponents\Discover;
use App\NativeComponents\Home;
use App\NativeComponents\PackageDetails;
use App\NativeLayouts\StackLayout;
use App\NativeLayouts\TabsLayout;
use Illuminate\Support\Facades\Route;

Route::nativeGroup(TabsLayout::class, function (): void {
    Route::native('/', Home::class)->name('home');
    Route::native('/discover', Discover::class)->name('discover');
});

Route::native('/packages/{package}', PackageDetails::class)
    ->layout(StackLayout::class)
    ->name('packages.show');
