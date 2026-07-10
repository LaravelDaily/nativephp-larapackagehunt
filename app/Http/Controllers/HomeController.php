<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $packages = [
            [
                'name' => 'AnySearch',
                'description' => 'Real-time structured search trusted by agents and developers',
            ],
            [
                'name' => 'Octolens',
                'description' => 'Social listening for the agent era',
            ],
            [
                'name' => 'Typeahead 2.0',
                'description' => 'Private AI autocomplete for every app on your Mac',
            ],
            [
                'name' => 'Sunrise',
                'description' => 'A real planner for Google Tasks',
            ],
            [
                'name' => 'Edgee Claude Code Compressor V2',
                'description' => 'Fewer tokens, same context. 50% smaller prompts',
            ],
        ];

        return view('home', compact('packages'));
    }
}
