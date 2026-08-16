<?php

namespace App\Livewire\Admin\Services;

use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Edit extends Component
{
    use WithFileUploads;

    public Service $serviceModel;

    public array $serviceData = [
        'title' => '',
        'slug' => '',
        'excerpt' => '',
        'description' => '',
        'sort_order' => 0,
        'is_active' => true,
        'cta_label' => '',
        'cta_url' => '',
    ];

    public mixed $image = null;

    public ?string $existingImage = null;

    public array $features = [];

    public array $portfolio_category_ids = [];

    public function mount(Service $service): void
    {
        $this->serviceModel = $service->load(['features', 'portfolioCategories']);

        $this->serviceData = [
            'title' => $service->title,
            'slug' => $service->slug,
            'excerpt' => $service->excerpt ?? '',
            'description' => $service->description ?? '',
            'sort_order' => $service->sort_order,
            'is_active' => (bool) $service->is_active,
            'cta_label' => $service->cta_label ?? 'Konsultasi Layanan Ini',
            'cta_url' => $service->cta_url ?? '/kontak',
        ];

        $this->existingImage = $service->image_src;

        $this->features = $service->features->map(fn ($f) => ['text' => $f->text])->all();
        if (empty($this->features)) {
            $this->features = [['text' => '']];
        }

        $this->portfolio_category_ids = $service->portfolioCategories->pluck('id')->all();
    }

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
            'serviceData.title' => ['required', 'string', 'max:255'],
            'serviceData.slug' => ['nullable', 'string', 'max:255', 'unique:services,slug,'.$this->serviceModel->id],
            'serviceData.excerpt' => ['nullable', 'string', 'max:500'],
            'serviceData.description' => ['nullable', 'string'],
            'serviceData.sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'features.*.text' => ['nullable', 'string', 'max:255'],
        ], [
            'serviceData.title.required' => 'Nama / Judul layanan wajib diisi.',
            'serviceData.title.max' => 'Nama / Judul layanan tidak boleh lebih dari 255 karakter.',
            'serviceData.slug.unique' => 'Slug sudah digunakan oleh layanan lain.',
            'serviceData.slug.max' => 'Slug tidak boleh lebih dari 255 karakter.',
            'serviceData.excerpt.max' => 'Ringkasan tidak boleh lebih dari 500 karakter.',
            'serviceData.sort_order.integer' => 'Urutan tampil harus berupa angka.',
            'serviceData.sort_order.min' => 'Urutan tampil minimal bernilai 0.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal adalah 4MB.',
            'features.*.text.max' => 'Teks fitur tidak boleh lebih dari 255 karakter.',
        ]);

        $serviceService->updateService($this->serviceModel, [
            'service' => $this->serviceData,
            'features' => $this->features,
            'portfolio_category_ids' => $this->portfolio_category_ids,
        ], $this->image);

        session()->flash('status', 'Layanan berhasil diperbarui.');
        $this->redirect(route('admin.services.index'), navigate: true);
    }

    public function render(): View
    {
        $allCategories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('livewire.admin.services.edit', compact('allCategories'));
    }
}
