<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()->orderBy('sort_order')->get();

        return view('admin.services.index', compact('services'));
    }

    public function create(Request $request)
    {
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('admin.services.form', [
            'service' => new Service(),
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($request, $data): void {
            $service = new Service();
            $service->fill($data['service']);
            $service->slug = $service->slug ?: Str::slug($service->title);

            if ($request->hasFile('service.image')) {
                $service->image_path = $request->file('service.image')->store('services', 'public');
            }

            $service->save();

            $service->portfolioCategories()->sync($data['portfolio_category_ids'] ?? []);

            foreach (($data['features'] ?? []) as $i => $row) {
                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => $row['text'],
                    'sort_order' => $i + 1,
                ]);
            }
        });

        return redirect()->route('admin.services.index')->with('status', 'Layanan dibuat.');
    }

    public function edit(Request $request, Service $service)
    {
        $service->load(['features', 'portfolioCategories']);
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('admin.services.form', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validatePayload($request, $service->id);

        DB::transaction(function () use ($request, $data, $service): void {
            $service->fill($data['service']);
            $service->slug = $service->slug ?: Str::slug($service->title);

            if ($request->hasFile('service.image')) {
                $service->image_path = $request->file('service.image')->store('services', 'public');
            }

            $service->save();

            $service->portfolioCategories()->sync($data['portfolio_category_ids'] ?? []);

            $service->features()->delete();
            foreach (($data['features'] ?? []) as $i => $row) {
                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => $row['text'],
                    'sort_order' => $i + 1,
                ]);
            }
        });

        return redirect()->route('admin.services.index')->with('status', 'Layanan diperbarui.');
    }

    public function destroy(Request $request, Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Layanan dihapus.');
    }

    private function validatePayload(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'service.title' => ['required', 'string', 'max:255'],
            'service.slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($ignoreId),
            ],
            'service.excerpt' => ['nullable', 'string'],
            'service.description' => ['nullable', 'string'],
            'service.cta_label' => ['nullable', 'string', 'max:255'],
            'service.image_url' => ['nullable', 'string', 'max:255'],
            'service.image' => ['nullable', 'image', 'max:4096'],
            'service.is_active' => ['nullable', 'boolean'],
            'service.sort_order' => ['nullable', 'integer', 'min:0'],
            'portfolio_category_ids' => ['nullable', 'array'],
            'portfolio_category_ids.*' => ['integer', 'exists:portfolio_categories,id'],
            'features' => ['nullable', 'array'],
            'features.*.text' => ['required_with:features', 'string', 'max:255'],
        ]);
    }
}

