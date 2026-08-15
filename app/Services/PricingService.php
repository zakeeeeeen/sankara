<?php

namespace App\Services;

use App\Models\PricingFeature;
use App\Models\PricingPlan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PricingService
{
    /**
     * @return Collection<int, PricingPlan>
     */
    public function getPricingPlansWithFeatures(): Collection
    {
        return PricingPlan::query()->with('features')->orderBy('sort_order')->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function createPricingPlan(array $data): PricingPlan
    {
        return DB::transaction(function () use ($data): PricingPlan {
            $planData = $data['plan'] ?? [];
            $planData['is_popular'] = (bool) ($planData['is_popular'] ?? false);

            /** @var PricingPlan $plan */
            $plan = PricingPlan::query()->create($planData);

            foreach (($data['features'] ?? []) as $i => $feat) {
                if (! filled($feat['text'] ?? null)) {
                    continue;
                }
                PricingFeature::query()->create([
                    'pricing_plan_id' => $plan->id,
                    'text' => $feat['text'],
                    'sort_order' => $i + 1,
                ]);
            }

            return $plan;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updatePricingPlan(PricingPlan $plan, array $data): PricingPlan
    {
        return DB::transaction(function () use ($plan, $data): PricingPlan {
            $planData = $data['plan'] ?? [];
            $planData['is_popular'] = (bool) ($planData['is_popular'] ?? false);

            $plan->update($planData);

            $plan->features()->delete();
            foreach (($data['features'] ?? []) as $i => $feat) {
                if (! filled($feat['text'] ?? null)) {
                    continue;
                }
                PricingFeature::query()->create([
                    'pricing_plan_id' => $plan->id,
                    'text' => $feat['text'],
                    'sort_order' => $i + 1,
                ]);
            }

            return $plan;
        });
    }

    public function deletePricingPlan(PricingPlan $plan): bool
    {
        return (bool) $plan->delete();
    }
}
