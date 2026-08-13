<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'slug', 'sort_order'])]
class PortfolioCategory extends Model
{
    public function portfolios(): BelongsToMany
    {
        return $this->belongsToMany(Portfolio::class)->withTimestamps();
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_portfolio_category')->withTimestamps();
    }
}

