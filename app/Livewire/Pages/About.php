<?php

namespace App\Livewire\Pages;

use App\Services\PageService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.marketing')]
class About extends Component
{
    public function render(PageService $pageService): View
    {
        $page = $pageService->getAboutPage();

        return view('livewire.pages.about', compact('page'));
    }
}
