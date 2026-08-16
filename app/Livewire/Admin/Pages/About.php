<?php

namespace App\Livewire\Admin\Pages;

use App\Services\PageService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class About extends Component
{
    use WithFileUploads;

    #[Rule('required|string|max:255', message: [
        'required' => 'Nama halaman wajib diisi.',
        'max' => 'Nama halaman tidak boleh lebih dari 255 karakter.',
    ])]
    public string $title = '';

    #[Rule('nullable|string|max:255', message: [
        'max' => 'Hero title tidak boleh lebih dari 255 karakter.',
    ])]
    public string $hero_title = '';

    #[Rule('nullable|string|max:500', message: [
        'max' => 'Hero subtitle tidak boleh lebih dari 500 karakter.',
    ])]
    public string $hero_subtitle = '';

    #[Rule('nullable|string')]
    public string $body = '';

    public mixed $image = null;

    public ?string $existingImage = null;

    public function mount(PageService $pageService): void
    {
        $page = $pageService->getAboutPage();

        $this->title = $page->title;
        $this->hero_title = $page->hero_title ?? '';
        $this->hero_subtitle = $page->hero_subtitle ?? '';
        $this->body = $page->body ?? '';
        $this->existingImage = $page->image_src;
    }

    public function save(PageService $pageService): void
    {
        $this->validate();

        $page = $pageService->getAboutPage();

        $pageService->updatePage($page, [
            'title' => $this->title,
            'hero_title' => $this->hero_title ?: null,
            'hero_subtitle' => $this->hero_subtitle ?: null,
            'body' => $this->body ?: null,
        ], $this->image);

        $this->existingImage = $page->fresh()->image_src;
        $this->reset('image');

        session()->flash('status', 'Halaman Tentang Kami berhasil diperbarui.');
    }

    public function render(): View
    {
        return view('livewire.admin.pages.about');
    }
}
