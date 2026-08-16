<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'title',
    'slug',
    'excerpt',
    'description',
    'client_name',
    'project_url',
    'technologies',
    'published_at',
    'cover_image_path',
    'cover_image_url',
    'preview_image_path',
    'preview_image_url',
    'is_active',
    'sort_order',
])]
class Portfolio extends Model
{
    private function normalizePublicAssetUrl(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        if (str_starts_with($url, '/')) {
            return $url;
        }

        $path = parse_url($url, PHP_URL_PATH);
        if (! $path || ! str_starts_with($path, '/')) {
            return $url;
        }

        $publicFile = public_path(ltrim($path, '/'));
        if (is_file($publicFile)) {
            return $path;
        }

        return $url;
    }

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'is_active' => 'boolean',
            'technologies' => 'array',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PortfolioCategory::class)->withTimestamps();
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PortfolioSection::class)->orderBy('sort_order');
    }

    public function getCoverImageSrcAttribute(): ?string
    {
        if ($this->cover_image_path) {
            return Storage::url($this->cover_image_path);
        }

        return $this->normalizePublicAssetUrl($this->cover_image_url);
    }

    public function getPreviewImageSrcAttribute(): ?string
    {
        if ($this->preview_image_path) {
            return Storage::url($this->preview_image_path);
        }

        return $this->normalizePublicAssetUrl($this->preview_image_url);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
