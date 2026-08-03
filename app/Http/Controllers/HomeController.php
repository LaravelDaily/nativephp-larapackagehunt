<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $packages = Http::connectTimeout(3)
            ->timeout(5)
            ->get(Config::string('app.api_url').'/packages')
            ->throw()
            ->json('data');

        return view('home', compact('packages'));
    }
}
