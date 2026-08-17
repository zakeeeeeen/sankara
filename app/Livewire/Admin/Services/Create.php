<?php

namespace App\Livewire\Admin\Services;

use App\Models\PortfolioCategory;
use App\Services\ServiceService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Create extends Component
{
    use WithFileUploads;

    public array $service = [
        'title' => '',
        'slug' => '',
        'excerpt' => '',
        'description' => '',
        'sort_order' => 0,
        'is_active' => true,
        'cta_label' => 'Konsultasi Layanan Ini',
        'cta_url' => '/kontak',
    ];

    public mixed $image = null;

    public array $features = [
        ['text' => ''],
    ];

    public array $portfolio_category_ids = [];

    public function addFeature(): void
    {
        $this->features[] = ['text' => ''];
    }

    public function removeFeature(int $index): void
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }

    public function save(ServiceService $serviceService): void
    {
        $this->validate([
            'service.title' => ['required', 'string', 'max:255'],
            'service.slug' => ['nullable', 'string', 'max:255', 'unique:services,slug'],
            'service.excerpt' => ['nullable', 'string', 'max:500'],
            'service.description' => ['nullable', 'string'],
            'service.sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:10240'],
            'features.*.text' => ['nullable', 'string', 'max:255'],
        ], [
            'service.title.required' => 'Nama / Judul layanan wajib diisi.',
            'service.title.max' => 'Nama / Judul layanan tidak boleh lebih dari 255 karakter.',
            'service.slug.unique' => 'Slug sudah digunakan oleh layanan lain.',
            'service.slug.max' => 'Slug tidak boleh lebih dari 255 karakter.',
            'service.excerpt.max' => 'Ringkasan tidak boleh lebih dari 500 karakter.',
            'service.sort_order.integer' => 'Urutan tampil harus berupa angka.',
            'service.sort_order.min' => 'Urutan tampil minimal bernilai 0.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal adalah 4MB.',
            'features.*.text.max' => 'Teks fitur tidak boleh lebih dari 255 karakter.',
        ]);

        $serviceService->createService([
            'service' => $this->service,
            'features' => $this->features,
            'portfolio_category_ids' => $this->portfolio_category_ids,
        ], $this->image);

        session()->flash('status', 'Layanan berhasil ditambahkan.');
        $this->redirect(route('admin.services.index'), navigate: true);
    }

    public function render(): View
    {
        $allCategories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('livewire.admin.services.create', compact('allCategories'));
    }
}
