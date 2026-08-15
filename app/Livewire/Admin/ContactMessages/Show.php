<?php

namespace App\Livewire\Admin\ContactMessages;

use App\Models\ContactMessage;
use App\Services\ContactService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Show extends Component
{
    public ContactMessage $message;

    public function mount(ContactMessage $message): void
    {
        $this->message = $message;
    }

    public function delete(ContactService $contactService): void
    {
        $contactService->deleteMessage($this->message);
        session()->flash('status', 'Pesan kontak berhasil dihapus.');
        $this->redirectRoute('admin.contact-messages.index', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.admin.contact-messages.show');
    }
}
