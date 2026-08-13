<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $portfolios = Portfolio::query()->orderByDesc('published_at')->orderBy('sort_order')->get();

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create(Request $request)
    {
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('admin.portfolios.form', [
            'portfolio' => new Portfolio(),
            'categories' => $categories,
            'selected' => [],
            'sections' => [],
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($request, $data): void {
            $portfolio = new Portfolio();
            $portfolio->fill($data['portfolio']);
            $portfolio->slug = $portfolio->slug ?: Str::slug($portfolio->title);

            if ($request->hasFile('portfolio.cover_image')) {
                $portfolio->cover_image_path = $request->file('portfolio.cover_image')->store('portfolios', 'public');
            }
            if ($request->hasFile('portfolio.preview_image')) {
                $portfolio->preview_image_path = $request->file('portfolio.preview_image')->store('portfolios', 'public');
            }

            $portfolio->save();
            $portfolio->categories()->sync($data['categories'] ?? []);

            foreach (($data['sections'] ?? []) as $i => $row) {
                $section = new PortfolioSection();
                $section->portfolio_id = $portfolio->id;
                $section->heading = $row['heading'] ?? null;
                $section->body = $row['body'] ?? null;
                $section->image_url = $row['image_url'] ?? null;
                $section->sort_order = $i + 1;

                if ($request->hasFile("sections.$i.image")) {
                    $section->image_path = $request->file("sections.$i.image")->store('portfolios/sections', 'public');
                }

                $section->save();
            }
        });

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio dibuat.');
    }

    public function edit(Request $request, Portfolio $portfolio)
    {
        $portfolio->load(['categories', 'sections']);
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('admin.portfolios.form', [
            'portfolio' => $portfolio,
            'categories' => $categories,
            'selected' => $portfolio->categories->pluck('id')->all(),
            'sections' => $portfolio->sections->map(fn ($s) => [
                'heading' => $s->heading,
                'body' => $s->body,
                'image_url' => $s->image_url,
                'image_path' => $s->image_path,
                'image_src' => $s->image_src,
            ])->all(),
        ]);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $this->validatePayload($request, $portfolio->id);

        DB::transaction(function () use ($request, $data, $portfolio): void {
            $portfolio->fill($data['portfolio']);
            $portfolio->slug = $portfolio->slug ?: Str::slug($portfolio->title);

            if ($request->hasFile('portfolio.cover_image')) {
                $portfolio->cover_image_path = $request->file('portfolio.cover_image')->store('portfolios', 'public');
            }
            if ($request->hasFile('portfolio.preview_image')) {
                $portfolio->preview_image_path = $request->file('portfolio.preview_image')->store('portfolios', 'public');
            }

            $portfolio->save();
            $portfolio->categories()->sync($data['categories'] ?? []);

            $portfolio->sections()->delete();
            foreach (($data['sections'] ?? []) as $i => $row) {
                $section = new PortfolioSection();
                $section->portfolio_id = $portfolio->id;
                $section->heading = $row['heading'] ?? null;
                $section->body = $row['body'] ?? null;
                $section->image_url = $row['image_url'] ?? null;
                $section->sort_order = $i + 1;

                if ($request->hasFile("sections.$i.image")) {
                    $section->image_path = $request->file("sections.$i.image")->store('portfolios/sections', 'public');
                }

                $section->save();
            }
        });

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio diperbarui.');
    }

    public function destroy(Request $request, Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio dihapus.');
    }

    private function validatePayload(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'portfolio.title' => ['required', 'string', 'max:255'],
            'portfolio.slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('portfolios', 'slug')->ignore($ignoreId),
            ],
            'portfolio.excerpt' => ['nullable', 'string'],
            'portfolio.client_name' => ['nullable', 'string', 'max:255'],
            'portfolio.project_url' => ['nullable', 'string', 'max:255'],
            'portfolio.technologies' => ['nullable', 'array'],
            'portfolio.technologies.*' => ['nullable', 'string', 'max:80'],
            'portfolio.published_at' => ['nullable', 'date'],
            'portfolio.cover_image_url' => ['nullable', 'string', 'max:255'],
            'portfolio.preview_image_url' => ['nullable', 'string', 'max:255'],
            'portfolio.cover_image' => ['nullable', 'image', 'max:8192'],
            'portfolio.preview_image' => ['nullable', 'image', 'max:8192'],
            'portfolio.is_active' => ['nullable', 'boolean'],
            'portfolio.sort_order' => ['nullable', 'integer', 'min:0'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:portfolio_categories,id'],
            'sections' => ['nullable', 'array'],
            'sections.*.heading' => ['nullable', 'string', 'max:255'],
            'sections.*.body' => ['nullable', 'string'],
            'sections.*.image_url' => ['nullable', 'string', 'max:255'],
            'sections.*.image' => ['nullable', 'image', 'max:8192'],
        ]);
    }
}

