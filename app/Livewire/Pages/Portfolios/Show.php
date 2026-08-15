<?php

namespace App\Livewire\Pages\Portfolios;

use App\Services\PortfolioService;
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

    public function render(PortfolioService $portfolioService): View
    {
        $portfolio = $portfolioService->getPortfolioBySlug($this->slug);

        return view('livewire.pages.portfolios.show', compact('portfolio'));
    }
}
