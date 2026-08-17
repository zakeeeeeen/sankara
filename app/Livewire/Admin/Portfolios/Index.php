<?php

namespace App\Livewire\Admin\Portfolios;

use App\Models\Portfolio;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id, PortfolioService $portfolioService): void
    {
        $portfolio = Portfolio::query()->findOrFail($id);
        $portfolioService->deletePortfolio($portfolio);
        session()->flash('status', 'Portofolio berhasil dihapus.');
        $this->dispatch('notify', message: 'Portofolio berhasil dihapus.');
    }

    public function toggleActive(int $id): void
    {
        $portfolio = Portfolio::query()->findOrFail($id);
        $portfolio->update(['is_active' => ! $portfolio->is_active]);
        session()->flash('status', 'Status portofolio berhasil diperbarui.');
        $this->dispatch('notify', message: 'Status portofolio berhasil diperbarui.');
    }

    public function render(): View
    {
        $portfolios = Portfolio::query()
            ->when(filled($this->search), fn ($q) => $q->where('title', 'like', '%'.trim($this->search).'%'))
            ->with('categories:id,name,slug')
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(10);

        return view('livewire.admin.portfolios.index', compact('portfolios'));
    }
}
