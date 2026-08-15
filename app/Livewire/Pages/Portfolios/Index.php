<?php

namespace App\Livewire\Pages\Portfolios;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.marketing')]
class Index extends Component
{
    public function render(): View
    {
        return view('livewire.pages.portfolios.index');
    }
}
