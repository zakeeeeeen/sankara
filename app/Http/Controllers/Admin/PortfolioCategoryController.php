<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PortfolioCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('admin.portfolio-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('portfolio_categories', 'slug')],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        PortfolioCategory::query()->create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?: Str::slug($data['name']),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.portfolio-categories.index')->with('status', 'Kategori dibuat.');
    }

    public function update(Request $request, PortfolioCategory $portfolioCategory)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('portfolio_categories', 'slug')->ignore($portfolioCategory->id)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $portfolioCategory->update([
            'name' => $data['name'],
            'slug' => $data['slug'] ?: Str::slug($data['name']),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.portfolio-categories.index')->with('status', 'Kategori diperbarui.');
    }

    public function destroy(Request $request, PortfolioCategory $portfolioCategory)
    {
        $portfolioCategory->delete();

        return redirect()->route('admin.portfolio-categories.index')->with('status', 'Kategori dihapus.');
    }
}

