<?php

namespace App\Livewire\Pages;

use App\Services\ContactService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.marketing')]
class Contact extends Component
{
    public function render(ContactService $contactService): View
    {
        $contact = $contactService->getContactData();

        return view('livewire.pages.contact', compact('contact'));
    }
}
