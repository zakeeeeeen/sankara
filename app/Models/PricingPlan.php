<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'tag', 'description', 'price_text', 'is_popular', 'sort_order'])]
class PricingPlan extends Model
{
    protected function casts(): array
    {
        return [
            'is_popular' => 'boolean',
        ];
    }

    public function features(): HasMany
    {
        return $this->hasMany(PricingFeature::class)->orderBy('sort_order');
    }
}

