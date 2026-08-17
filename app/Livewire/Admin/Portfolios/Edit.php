<?php

namespace App\Livewire\Admin\Portfolios;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Edit extends Component
{
    use WithFileUploads;

    public Portfolio $portfolioModel;

    public array $portfolioData = [
        'title' => '',
        'slug' => '',
        'client_name' => '',
        'project_url' => '',
        'description' => '',
        'sort_order' => 0,
        'is_active' => true,
        'published_at' => '',
    ];

    public string $technologiesText = '';

    public mixed $cover_image = null;

    public ?string $existingCoverImage = null;

    public array $categories = [];

    public array $sections = [];

    public array $section_images = [];

    public function mount(Portfolio $portfolio): void
    {
        $this->portfolioModel = $portfolio->load(['categories', 'sections']);

        $this->portfolioData = [
            'title' => $portfolio->title,
            'slug' => $portfolio->slug,
            'client_name' => $portfolio->client_name ?? '',
            'project_url' => $portfolio->project_url ?? '',
            'description' => $portfolio->description ?? '',
            'sort_order' => $portfolio->sort_order,
            'is_active' => (bool) $portfolio->is_active,
            'published_at' => $portfolio->published_at ? $portfolio->published_at->format('Y-m-d') : '',
        ];

        $techs = is_array($portfolio->technologies) ? $portfolio->technologies : [];
        $this->technologiesText = implode(', ', $techs);

        $this->existingCoverImage = $portfolio->cover_image_src ?: $portfolio->preview_image_src;

        $this->categories = $portfolio->categories->pluck('id')->all();

        $this->sections = $portfolio->sections->map(fn ($s) => [
            'heading' => $s->heading ?? '',
            'body' => $s->body ?? '',
            'image_url' => $s->image_url ?? '',
        ])->all();

        if (empty($this->sections)) {
            $this->sections = [['heading' => '', 'body' => '', 'image_url' => '']];
        }
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
            'portfolioData.title' => ['required', 'string', 'max:255'],
            'portfolioData.slug' => ['nullable', 'string', 'max:255', 'unique:portfolios,slug,'.$this->portfolioModel->id],
            'portfolioData.description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'max:10240'],
        ], [
            'portfolioData.title.required' => 'Nama / Judul project wajib diisi.',
            'portfolioData.title.max' => 'Nama / Judul project tidak boleh lebih dari 255 karakter.',
            'portfolioData.slug.unique' => 'Slug sudah digunakan oleh project lain.',
            'portfolioData.slug.max' => 'Slug tidak boleh lebih dari 255 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.max' => 'Ukuran gambar maksimal adalah 10MB.',
        ]);

        $techs = array_values(array_filter(array_map('trim', explode(',', $this->technologiesText))));
        $pData = $this->portfolioData;
        $pData['technologies'] = $techs;
        if (empty($pData['published_at'])) {
            $pData['published_at'] = null;
        }

        $files = [];
        if ($this->cover_image) {
            $files['cover_image'] = $this->cover_image;
        }
        if (! empty($this->section_images)) {
            $files['section_images'] = $this->section_images;
        }

        $portfolioService->updatePortfolio($this->portfolioModel, [
            'portfolio' => $pData,
            'categories' => $this->categories,
            'sections' => $this->sections,
        ], $files);

        session()->flash('status', 'Portofolio berhasil diperbarui.');
        $this->redirect(route('admin.portfolios.index'), navigate: true);
    }

    public function render(): View
    {
        $allCategories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('livewire.admin.portfolios.edit', compact('allCategories'));
    }
}
