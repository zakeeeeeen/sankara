<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(Request $request, ContactService $contactService): View
    {
        $contact = $contactService->getContactData();

        return view('contact.show', compact('contact'));
    }

    public function store(Request $request, ContactService $contactService): RedirectResponse
    {
        // 1. Honeypot check for bots
        if (filled($request->input('_hp_website_title'))) {
            return redirect()
                ->route('contact.show')
                ->with('status', 'Pesan berhasil dikirim. Terima kasih!');
        }

        // 2. Rate limiting
        $seconds = $contactService->checkRateLimit((string) $request->ip(), 5, 60);
        if ($seconds !== null) {
            return back()
                ->withInput()
                ->withErrors(['rate_limit' => "Terlalu banyak permintaan. Silakan tunggu {$seconds} detik lagi."]);
        }

        // 3. Validation
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:32'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $result = $contactService->submitContactMessage($payload, $request->ip(), $request->userAgent());

        return redirect()
            ->route('contact.show')
            ->with('status', 'Pesan berhasil dikirim. Terima kasih!')
            ->with('wa_link', $result['wa_link']);
    }
}
