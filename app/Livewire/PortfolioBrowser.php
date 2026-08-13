<?php

namespace App\Livewire;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class PortfolioBrowser extends Component
{
    use WithPagination;

    public string $category = 'all';

    public string $search = '';

    public string $service = '';

    public array $serviceCategoryIds = [];

    public function mount(): void
    {
        $this->category = (string) request()->query('category', $this->category);
        $this->search = (string) request()->query('search', $this->search);
        $this->service = (string) request()->query('service', $this->service);

        if (trim($this->service) !== '') {
            $service = Service::query()
                ->where('slug', trim($this->service))
                ->with('portfolioCategories:id')
                ->first();

            if ($service) {
                $this->serviceCategoryIds = $service->portfolioCategories->pluck('id')->all();
            }
        }
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        $query = Portfolio::query()
            ->active()
            ->with('categories')
            ->orderByDesc('published_at')
            ->orderBy('sort_order');

        if (count($this->serviceCategoryIds) > 0) {
            $query->whereHas('categories', fn ($q) => $q->whereIn('portfolio_categories.id', $this->serviceCategoryIds));
        }

        if ($this->category !== 'all') {
            $query->whereHas('categories', fn ($q) => $q->where('slug', $this->category));
        }

        if (trim($this->search) !== '') {
            $query->where('title', 'like', '%' . trim($this->search) . '%');
        }

        return view('livewire.portfolio-browser', [
            'categories' => $categories,
            'portfolios' => $query->paginate(9),
        ]);
    }
}

