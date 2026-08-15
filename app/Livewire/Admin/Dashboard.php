<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Dashboard extends Component
{
    public function render(DashboardService $dashboardService): View
    {
        $data = $dashboardService->getDashboardData();

        return view('livewire.admin.dashboard', $data);
    }
}
