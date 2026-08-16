<?php

namespace App\Livewire\Admin\Pricing;

use App\Models\PricingPlan;
use App\Services\PricingService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Edit extends Component
{
    public PricingPlan $planModel;

    public array $planData = [
        'name' => '',
        'tag' => '',
        'price_text' => '',
        'description' => '',
        'sort_order' => 0,
        'is_popular' => false,
    ];

    public array $features = [];

    public function mount(PricingPlan $plan): void
    {
        $this->planModel = $plan->load('features');

        $this->planData = [
            'name' => $plan->name,
            'tag' => $plan->tag ?? '',
            'price_text' => $plan->price_text ?? '',
            'description' => $plan->description ?? '',
            'sort_order' => $plan->sort_order,
            'is_popular' => (bool) $plan->is_popular,
        ];

        $this->features = $plan->features->map(fn ($f) => ['text' => $f->text])->all();
        if (empty($this->features)) {
            $this->features = [['text' => '']];
        }
    }

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
            'planData.name' => ['required', 'string', 'max:255'],
            'planData.tag' => ['nullable', 'string', 'max:255'],
            'planData.price_text' => ['nullable', 'string', 'max:255'],
            'planData.description' => ['nullable', 'string'],
            'planData.sort_order' => ['nullable', 'integer', 'min:0'],
            'features.*.text' => ['nullable', 'string', 'max:255'],
        ]);

        $pricingService->updatePricingPlan($this->planModel, [
            'plan' => $this->planData,
            'features' => $this->features,
        ]);

        session()->flash('status', 'Paket harga berhasil diperbarui.');
        $this->redirect(route('admin.pricing.index'), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.pricing.edit');
    }
}
