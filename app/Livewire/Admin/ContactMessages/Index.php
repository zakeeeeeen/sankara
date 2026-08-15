<?php

namespace App\Livewire\Admin\ContactMessages;

use App\Models\ContactMessage;
use App\Services\ContactService;
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

    public function delete(int $id, ContactService $contactService): void
    {
        $message = ContactMessage::query()->findOrFail($id);
        $contactService->deleteMessage($message);
        session()->flash('status', 'Pesan kontak berhasil dihapus.');
    }

    public function render(): View
    {
        $query = ContactMessage::query()->latest();

        $trimmed = trim($this->search);
        if ($trimmed !== '') {
            $query->where(function ($q) use ($trimmed): void {
                $q->where('name', 'like', '%'.$trimmed.'%')
                    ->orWhere('email', 'like', '%'.$trimmed.'%')
                    ->orWhere('phone', 'like', '%'.$trimmed.'%')
                    ->orWhere('message', 'like', '%'.$trimmed.'%');
            });
        }

        return view('livewire.admin.contact-messages.index', [
            'messages' => $query->paginate(15),
        ]);
    }
}
