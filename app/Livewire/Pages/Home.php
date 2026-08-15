<?php

namespace App\Livewire\Pages;

use App\Services\HomeService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.marketing')]
class Home extends Component
{
    public function render(HomeService $homeService): View
    {
        $data = $homeService->getLandingPageData();

        return view('livewire.pages.home', $data);
    }
}
