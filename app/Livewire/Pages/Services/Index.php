<?php

namespace App\Livewire\Pages\Services;

use App\Services\ServiceService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.marketing')]
class Index extends Component
{
    public function render(ServiceService $serviceService): View
    {
        $services = $serviceService->getActiveServices();

        return view('livewire.pages.services.index', compact('services'));
    }
}
