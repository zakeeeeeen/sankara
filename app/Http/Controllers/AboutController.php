<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = Page::query()->where('slug', 'tentang-kami')->firstOrFail();

        return view('pages.show', compact('page'));
    }
}

