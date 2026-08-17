<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioSection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PortfolioService
{
    public function getPortfolioBySlug(string $slug): Portfolio
    {
        /** @var Portfolio */
        return Portfolio::query()
            ->active()
            ->where('slug', $slug)
            ->with(['categories', 'sections'])
            ->firstOrFail();
    }

    /**
     * @param  array<int, int>  $categoryIds
     * @return Collection<int, Portfolio>
     */
    public function getRelatedPortfolios(array $categoryIds, int $limit = 3): Collection
    {
        if (empty($categoryIds)) {
            return new Collection;
        }

        return Portfolio::query()
            ->active()
            ->whereHas('categories', fn ($q) => $q->whereIn('portfolio_categories.id', $categoryIds))
            ->with('categories:id,name,slug')
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->limit($limit)
            ->get();
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, UploadedFile|array<int, UploadedFile|null>>  $files
     */
    public function createPortfolio(array $data, array $files = []): Portfolio
    {
        return DB::transaction(function () use ($data, $files): Portfolio {
            $pData = $data['portfolio'] ?? [];
            if (! filled($pData['slug'] ?? null)) {
                $pData['slug'] = Str::slug($pData['title'] ?? '');
            }
            $pData['is_active'] = (bool) ($pData['is_active'] ?? false);

            if (isset($pData['technologies']) && is_array($pData['technologies'])) {
                $pData['technologies'] = array_values(array_filter($pData['technologies'], fn ($t) => filled($t)));
            }

            if (isset($files['cover_image']) && $files['cover_image'] instanceof UploadedFile) {
                $path = ImageService::storeAsWebp($files['cover_image'], 'portfolios');
                $pData['cover_image_path'] = $path;
                $pData['preview_image_path'] = $path;
            }
            if (isset($files['preview_image']) && $files['preview_image'] instanceof UploadedFile) {
                $path = ImageService::storeAsWebp($files['preview_image'], 'portfolios');
                $pData['preview_image_path'] = $path;
                if (! isset($pData['cover_image_path'])) {
                    $pData['cover_image_path'] = $path;
                }
            }

            /** @var Portfolio $portfolio */
            $portfolio = Portfolio::query()->create($this->filterValidColumns($pData));

            if (isset($data['categories'])) {
                $portfolio->categories()->sync((array) $data['categories']);
            }

            $sectionImages = $files['section_images'] ?? [];
            foreach (($data['sections'] ?? []) as $i => $row) {
                $heading = trim((string) ($row['heading'] ?? ''));
                $body = trim((string) ($row['body'] ?? ''));
                $imageUrl = trim((string) ($row['image_url'] ?? ''));
                $hasImageFile = isset($sectionImages[$i]) && $sectionImages[$i] instanceof UploadedFile;

                if ($heading === '' && $body === '' && $imageUrl === '' && ! $hasImageFile) {
                    continue;
                }

                $section = new PortfolioSection;
                $section->portfolio_id = $portfolio->id;
                $section->heading = $heading ?: null;
                $section->body = $body ?: null;
                $section->image_url = $imageUrl ?: null;
                $section->sort_order = $i + 1;

                if ($hasImageFile) {
                    $section->image_path = ImageService::storeAsWebp($sectionImages[$i], 'portfolios/sections');
                }

                $section->save();
            }

            return $portfolio;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, UploadedFile|array<int, UploadedFile|null>>  $files
     */
    public function updatePortfolio(Portfolio $portfolio, array $data, array $files = []): Portfolio
    {
        return DB::transaction(function () use ($portfolio, $data, $files): Portfolio {
            $pData = $data['portfolio'] ?? [];
            if (! filled($pData['slug'] ?? null)) {
                $pData['slug'] = Str::slug($pData['title'] ?? '');
            }
            $pData['is_active'] = (bool) ($pData['is_active'] ?? false);

            if (isset($pData['technologies']) && is_array($pData['technologies'])) {
                $pData['technologies'] = array_values(array_filter($pData['technologies'], fn ($t) => filled($t)));
            }

            if (isset($files['cover_image']) && $files['cover_image'] instanceof UploadedFile) {
                $path = ImageService::storeAsWebp($files['cover_image'], 'portfolios');
                $pData['cover_image_path'] = $path;
                $pData['preview_image_path'] = $path;
            }
            if (isset($files['preview_image']) && $files['preview_image'] instanceof UploadedFile) {
                $path = ImageService::storeAsWebp($files['preview_image'], 'portfolios');
                $pData['preview_image_path'] = $path;
                if (! isset($pData['cover_image_path'])) {
                    $pData['cover_image_path'] = $path;
                }
            }

            $portfolio->update($this->filterValidColumns($pData));

            $portfolio->categories()->sync((array) ($data['categories'] ?? []));

            $portfolio->sections()->delete();

            $sectionImages = $files['section_images'] ?? [];
            foreach (($data['sections'] ?? []) as $i => $row) {
                $heading = trim((string) ($row['heading'] ?? ''));
                $body = trim((string) ($row['body'] ?? ''));
                $imageUrl = trim((string) ($row['image_url'] ?? ''));
                $hasImageFile = isset($sectionImages[$i]) && $sectionImages[$i] instanceof UploadedFile;

                if ($heading === '' && $body === '' && $imageUrl === '' && ! $hasImageFile) {
                    continue;
                }

                $section = new PortfolioSection;
                $section->portfolio_id = $portfolio->id;
                $section->heading = $heading ?: null;
                $section->body = $body ?: null;
                $section->image_url = $imageUrl ?: null;
                $section->sort_order = $i + 1;

                if ($hasImageFile) {
                    $section->image_path = ImageService::storeAsWebp($sectionImages[$i], 'portfolios/sections');
                }

                $section->save();
            }

            return $portfolio;
        });
    }

    public function deletePortfolio(Portfolio $portfolio): bool
    {
        return (bool) $portfolio->delete();
    }

    /**
     * @param  array{name: string, slug?: ?string, sort_order?: int}  $data
     */
    public function createCategory(array $data): PortfolioCategory
    {
        $slug = filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data['name']);

        return PortfolioCategory::query()->create([
            'name' => $data['name'],
            'slug' => $slug,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);
    }

    /**
     * @param  array{name: string, slug?: ?string, sort_order?: int}  $data
     */
    public function updateCategory(PortfolioCategory $category, array $data): PortfolioCategory
    {
        $slug = filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $category->update([
            'name' => $data['name'],
            'slug' => $slug,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ]);

        return $category;
    }

    public function deleteCategory(PortfolioCategory $category): bool
    {
        return (bool) $category->delete();
    }

    /**
     * Filter array attributes so only existing table columns are sent to query builder.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    private function filterValidColumns(array $attributes): array
    {
        try {
            $columns = Schema::getColumnListing('portfolios');
            if (! empty($columns)) {
                return array_intersect_key($attributes, array_flip($columns));
            }
        } catch (\Throwable) {
            // Fallback
        }

        return $attributes;
    }
}
