<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    public string $search = '';

    public function delete(int $id, ServiceService $serviceService): void
    {
        $service = Service::query()->findOrFail($id);
        $serviceService->deleteService($service);
        session()->flash('status', 'Layanan berhasil dihapus.');
    }

    public function toggleActive(int $id): void
    {
        $service = Service::query()->findOrFail($id);
        $service->update(['is_active' => ! $service->is_active]);
        session()->flash('status', 'Status layanan berhasil diperbarui.');
    }

    public function render(): View
    {
        $services = Service::query()
            ->when(filled($this->search), fn ($q) => $q->where('title', 'like', '%'.trim($this->search).'%'))
            ->withCount('features')
            ->orderBy('sort_order')
            ->get();

        return view('livewire.admin.services.index', compact('services'));
    }
}
