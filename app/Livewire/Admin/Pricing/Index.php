<?php

namespace App\Livewire\Admin\Pricing;

use App\Models\PricingPlan;
use App\Services\PricingService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public function delete(int $id, PricingService $pricingService): void
    {
        $plan = PricingPlan::query()->findOrFail($id);
        $pricingService->deletePricingPlan($plan);
        session()->flash('status', 'Paket harga berhasil dihapus.');
    }

    public function togglePopular(int $id): void
    {
        $plan = PricingPlan::query()->findOrFail($id);
        $plan->update(['is_popular' => ! $plan->is_popular]);
        session()->flash('status', 'Status paket populer berhasil diperbarui.');
    }

    public function render(PricingService $pricingService): View
    {
        $plans = $pricingService->getPricingPlansWithFeatures();

        return view('livewire.admin.pricing.index', compact('plans'));
    }
}
