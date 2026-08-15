<?php

namespace App\Livewire\Pages\Services;

use App\Services\PortfolioService;
use App\Services\ServiceService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.marketing')]
class Show extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    public function render(ServiceService $serviceService, PortfolioService $portfolioService): View
    {
        $service = $serviceService->getServiceBySlug($this->slug);
        $categoryIds = $service->portfolioCategories->pluck('id')->all();
        $relatedPortfolios = $portfolioService->getRelatedPortfolios($categoryIds, 3);

        return view('livewire.pages.services.show', compact('service', 'relatedPortfolios'));
    }
}
