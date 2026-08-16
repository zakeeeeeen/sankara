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
    'cta_label',
    'cta_url',
    'image_path',
    'image_url',
    'is_active',
    'sort_order',
])]
class Service extends Model
{
    public function features(): HasMany
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('sort_order');
    }

    public function portfolioCategories(): BelongsToMany
    {
        return $this->belongsToMany(PortfolioCategory::class, 'service_portfolio_category')->withTimestamps();
    }

    public function getImageSrcAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }

        return $this->image_url;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
