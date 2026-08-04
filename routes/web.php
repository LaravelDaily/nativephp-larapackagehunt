<?php

use App\NativeComponents\Home;
use App\NativeComponents\PackageDetails;
use App\NativeLayouts\StackLayout;
use App\NativeLayouts\TabsLayout;
use Illuminate\Support\Facades\Route;

Route::native('/', Home::class)
    ->layout(TabsLayout::class)
    ->name('home');

Route::native('/packages/anysearch', PackageDetails::class)
    ->layout(StackLayout::class)
    ->name('packages.show');
