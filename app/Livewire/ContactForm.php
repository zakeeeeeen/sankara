<?php

namespace App\Livewire;

use App\Services\ContactService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ContactForm extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|max:255')]
    public string $email = '';

    #[Rule('nullable|string|max:32')]
    public string $phone = '';

    #[Rule('required|string|max:5000')]
    public string $message = '';

    public string $honeypot = '';

    public ?string $status = null;

    public ?string $waLink = null;

    public function submit(ContactService $contactService): void
    {
        if (filled($this->honeypot)) {
            $this->status = 'Pesan berhasil dikirim. Terima kasih!';
            $this->reset(['name', 'email', 'phone', 'message', 'honeypot']);

            return;
        }

        $seconds = $contactService->checkRateLimit((string) request()->ip(), 5, 60);
        if ($seconds !== null) {
            $this->addError('rate_limit', "Terlalu banyak permintaan. Silakan tunggu {$seconds} detik lagi.");

            return;
        }

        $validated = $this->validate();

        $result = $contactService->submitContactMessage($validated, request()->ip(), request()->userAgent());

        $this->status = 'Pesan berhasil dikirim. Terima kasih!';
        $this->waLink = $result['wa_link'];

        $this->reset(['name', 'email', 'phone', 'message', 'honeypot']);
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}
