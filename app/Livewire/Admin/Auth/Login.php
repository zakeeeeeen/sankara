<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.admin')]
class Login extends Component
{
    #[Rule('required|email', message: [
        'required' => 'Email wajib diisi.',
        'email' => 'Format email tidak valid.',
    ])]
    public string $email = '';

    #[Rule('required|string', message: [
        'required' => 'Password wajib diisi.',
    ])]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $throttleKey = 'admin-login:'.request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('email', "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.");

            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();

            if (! Auth::user()->is_admin) {
                Auth::logout();
                $this->addError('email', 'Akses ditolak. Akun bukan administrator.');

                return;
            }

            $this->redirectIntended(route('admin.dashboard'), navigate: true);

            return;
        }

        RateLimiter::hit($throttleKey, 60);
        $this->addError('email', 'Email atau password yang Anda masukkan salah.');
    }

    public function render(): View
    {
        return view('livewire.admin.auth.login');
    }
}
