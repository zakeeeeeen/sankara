<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'heading',
    'subheading',
    'primary_cta_label',
    'primary_cta_url',
    'secondary_cta_label',
    'secondary_cta_url',
    'image_path',
    'image_url',
])]
class HomeHero extends Model
{
    public function getImageSrcAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }

        return $this->image_url;
    }
}
