<?php

namespace App\Livewire\Admin\Portfolios;

use App\Models\PortfolioCategory;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Create extends Component
{
    use WithFileUploads;

    public array $portfolio = [
        'title' => '',
        'slug' => '',
        'client_name' => '',
        'project_url' => '',
        'excerpt' => '',
        'description' => '',
        'sort_order' => 0,
        'is_active' => true,
        'published_at' => '',
    ];

    public string $technologiesText = 'Laravel, Livewire, Tailwind CSS';

    public mixed $cover_image = null;

    public mixed $preview_image = null;

    public array $categories = [];

    public array $sections = [
        ['heading' => '', 'body' => '', 'image_url' => ''],
    ];

    public array $section_images = [];

    public function mount(): void
    {
        $this->portfolio['published_at'] = date('Y-m-d');
    }

    public function addSection(): void
    {
        $this->sections[] = ['heading' => '', 'body' => '', 'image_url' => ''];
    }

    public function removeSection(int $index): void
    {
        unset($this->sections[$index]);
        $this->sections = array_values($this->sections);

        if (isset($this->section_images[$index])) {
            unset($this->section_images[$index]);
            $this->section_images = array_values($this->section_images);
        }
    }

    public function save(PortfolioService $portfolioService): void
    {
        $this->validate([
            'portfolio.title' => ['required', 'string', 'max:255'],
            'portfolio.slug' => ['nullable', 'string', 'max:255', 'unique:portfolios,slug'],
            'portfolio.excerpt' => ['nullable', 'string', 'max:500'],
            'portfolio.description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'preview_image' => ['nullable', 'image', 'max:4096'],
        ], [
            'portfolio.title.required' => 'Nama / Judul project wajib diisi.',
            'portfolio.title.max' => 'Nama / Judul project tidak boleh lebih dari 255 karakter.',
            'portfolio.slug.unique' => 'Slug sudah digunakan oleh project lain.',
            'portfolio.slug.max' => 'Slug tidak boleh lebih dari 255 karakter.',
            'portfolio.excerpt.max' => 'Ringkasan tidak boleh lebih dari 500 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.max' => 'Ukuran gambar maksimal adalah 4MB.',
            'preview_image.image' => 'File harus berupa gambar.',
            'preview_image.max' => 'Ukuran gambar maksimal adalah 4MB.',
        ]);

        $techs = array_values(array_filter(array_map('trim', explode(',', $this->technologiesText))));
        $pData = $this->portfolio;
        $pData['technologies'] = $techs;
        if (empty($pData['published_at'])) {
            $pData['published_at'] = null;
        }

        $files = [];
        if ($this->cover_image) {
            $files['cover_image'] = $this->cover_image;
        }
        if ($this->preview_image) {
            $files['preview_image'] = $this->preview_image;
        }
        if (! empty($this->section_images)) {
            $files['section_images'] = $this->section_images;
        }

        $portfolioService->createPortfolio([
            'portfolio' => $pData,
            'categories' => $this->categories,
            'sections' => $this->sections,
        ], $files);

        session()->flash('status', 'Portofolio berhasil ditambahkan.');
        $this->redirect(route('admin.portfolios.index'), navigate: true);
    }

    public function render(): View
    {
        $allCategories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('livewire.admin.portfolios.create', compact('allCategories'));
    }
}
