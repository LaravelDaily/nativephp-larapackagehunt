<?php

use App\NativeComponents\Home;
use App\NativeComponents\PackageDetails;
use App\NativeLayouts\DetailLayout;
use App\NativeLayouts\HomeLayout;
use Illuminate\Support\Facades\Route;

Route::native('/', Home::class)
    ->layout(HomeLayout::class)
    ->name('home');

Route::native('/packages/anysearch', PackageDetails::class)
    ->layout(DetailLayout::class)
    ->name('packages.show');
