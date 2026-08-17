<?php

namespace App\Livewire\Admin\PortfolioCategories;

use App\Models\PortfolioCategory;
use App\Services\PortfolioService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    #[Rule('required|string|max:255', message: [
        'required' => 'Nama kategori wajib diisi.',
        'max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
    ])]
    public string $name = '';

    #[Rule('nullable|string|max:255')]
    public string $slug = '';

    #[Rule('nullable|integer|min:0')]
    public int $sort_order = 0;

    public ?int $editingCategoryId = null;

    #[Rule('required|string|max:255', message: [
        'required' => 'Nama kategori wajib diisi.',
        'max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
    ])]
    public string $editName = '';

    #[Rule('nullable|string|max:255')]
    public string $editSlug = '';

    #[Rule('nullable|integer|min:0')]
    public int $editSortOrder = 0;

    public bool $createModalOpen = false;

    public bool $editModalOpen = false;

    public function openCreateModal(): void
    {
        $this->reset(['name', 'slug', 'sort_order']);
        $this->resetValidation();
        $this->createModalOpen = true;
    }

    public function closeCreateModal(): void
    {
        $this->createModalOpen = false;
    }

    public function store(PortfolioService $portfolioService): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:portfolio_categories,slug'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan oleh kategori lain.',
            'slug.max' => 'Slug tidak boleh lebih dari 255 karakter.',
            'sort_order.integer' => 'Urutan harus berupa angka.',
            'sort_order.min' => 'Urutan minimal bernilai 0.',
        ]);

        $portfolioService->createCategory([
            'name' => $this->name,
            'slug' => $this->slug ?: null,
            'sort_order' => $this->sort_order,
        ]);

        $this->createModalOpen = false;
        $this->reset(['name', 'slug', 'sort_order']);
        session()->flash('status', 'Kategori berhasil ditambahkan.');
        $this->dispatch('notify', message: 'Kategori berhasil ditambahkan.');
    }

    public function openEditModal(int $id): void
    {
        $category = PortfolioCategory::query()->findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->editName = $category->name;
        $this->editSlug = $category->slug;
        $this->editSortOrder = $category->sort_order;
        $this->resetValidation();
        $this->editModalOpen = true;
    }

    public function closeEditModal(): void
    {
        $this->editModalOpen = false;
        $this->editingCategoryId = null;
    }

    public function update(PortfolioService $portfolioService): void
    {
        if (! $this->editingCategoryId) {
            return;
        }

        $category = PortfolioCategory::query()->findOrFail($this->editingCategoryId);

        $this->validate([
            'editName' => ['required', 'string', 'max:255'],
            'editSlug' => ['nullable', 'string', 'max:255', 'unique:portfolio_categories,slug,'.$category->id],
            'editSortOrder' => ['nullable', 'integer', 'min:0'],
        ], [
            'editName.required' => 'Nama kategori wajib diisi.',
            'editName.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'editSlug.unique' => 'Slug sudah digunakan oleh kategori lain.',
            'editSlug.max' => 'Slug tidak boleh lebih dari 255 karakter.',
            'editSortOrder.integer' => 'Urutan harus berupa angka.',
            'editSortOrder.min' => 'Urutan minimal bernilai 0.',
        ]);

        $portfolioService->updateCategory($category, [
            'name' => $this->editName,
            'slug' => $this->editSlug ?: null,
            'sort_order' => $this->editSortOrder,
        ]);

        $this->editModalOpen = false;
        $this->editingCategoryId = null;
        session()->flash('status', 'Kategori berhasil diperbarui.');
        $this->dispatch('notify', message: 'Kategori berhasil diperbarui.');
    }

    public function delete(int $id, PortfolioService $portfolioService): void
    {
        $category = PortfolioCategory::query()->findOrFail($id);
        $portfolioService->deleteCategory($category);
        session()->flash('status', 'Kategori berhasil dihapus.');
        $this->dispatch('notify', message: 'Kategori berhasil dihapus.');
    }

    public function render(): View
    {
        $categories = PortfolioCategory::query()->orderBy('sort_order')->get();

        return view('livewire.admin.portfolio-categories.index', compact('categories'));
    }
}
