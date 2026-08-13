<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingFeature;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = PricingPlan::query()->orderBy('sort_order')->get();

        return view('admin.pricing.index', compact('plans'));
    }

    public function create(Request $request)
    {
        return view('admin.pricing.form', ['plan' => new PricingPlan()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($data): void {
            $plan = new PricingPlan();
            $plan->fill($data['plan']);
            $plan->save();

            foreach (($data['features'] ?? []) as $i => $row) {
                PricingFeature::query()->create([
                    'pricing_plan_id' => $plan->id,
                    'text' => $row['text'],
                    'sort_order' => $i + 1,
                ]);
            }
        });

        return redirect()->route('admin.pricing.index')->with('status', 'Paket dibuat.');
    }

    public function edit(Request $request, PricingPlan $plan)
    {
        $plan->load('features');

        return view('admin.pricing.form', compact('plan'));
    }

    public function update(Request $request, PricingPlan $plan)
    {
        $data = $this->validatePayload($request);

        DB::transaction(function () use ($data, $plan): void {
            $plan->fill($data['plan']);
            $plan->save();

            $plan->features()->delete();
            foreach (($data['features'] ?? []) as $i => $row) {
                PricingFeature::query()->create([
                    'pricing_plan_id' => $plan->id,
                    'text' => $row['text'],
                    'sort_order' => $i + 1,
                ]);
            }
        });

        return redirect()->route('admin.pricing.index')->with('status', 'Paket diperbarui.');
    }

    public function destroy(Request $request, PricingPlan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.pricing.index')->with('status', 'Paket dihapus.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'plan.name' => ['required', 'string', 'max:255'],
            'plan.tag' => ['nullable', 'string', 'max:255'],
            'plan.description' => ['nullable', 'string'],
            'plan.price_text' => ['nullable', 'string', 'max:255'],
            'plan.is_popular' => ['nullable', 'boolean'],
            'plan.sort_order' => ['nullable', 'integer', 'min:0'],
            'features' => ['nullable', 'array'],
            'features.*.text' => ['required_with:features', 'string', 'max:255'],
        ]);
    }
}

