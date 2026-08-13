<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        return view('portfolios.index');
    }

    public function show(Request $request, string $slug)
    {
        $portfolio = Portfolio::query()
            ->active()
            ->where('slug', $slug)
            ->with(['categories', 'sections'])
            ->firstOrFail();

        return view('portfolios.show', compact('portfolio'));
    }
}

