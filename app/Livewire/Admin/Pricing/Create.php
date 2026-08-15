<?php

namespace App\Livewire\Admin\Pricing;

use App\Services\PricingService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Create extends Component
{
    public array $plan = [
        'name' => '',
        'tag' => '',
        'price_text' => '',
        'description' => '',
        'sort_order' => 0,
        'is_popular' => false,
    ];

    public array $features = [
        ['text' => ''],
    ];

    public function addFeature(): void
    {
        $this->features[] = ['text' => ''];
    }

    public function removeFeature(int $index): void
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function save(PricingService $pricingService): void
    {
        $this->validate([
            'plan.name' => ['required', 'string', 'max:255'],
            'plan.tag' => ['nullable', 'string', 'max:255'],
            'plan.price_text' => ['nullable', 'string', 'max:255'],
            'plan.description' => ['nullable', 'string'],
            'plan.sort_order' => ['nullable', 'integer', 'min:0'],
            'features.*.text' => ['nullable', 'string', 'max:255'],
        ]);

        $pricingService->createPricingPlan([
            'plan' => $this->plan,
            'features' => $this->features,
        ]);

        session()->flash('status', 'Paket harga berhasil ditambahkan.');
        $this->redirect(route('admin.pricing.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.pricing.create');
    }
}
