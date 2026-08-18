<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable(['slug', 'title', 'hero_title', 'hero_subtitle', 'body', 'image_path', 'image_url'])]
class Page extends Model
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

    public function getImageSrcAttribute(): ?string
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }

        return $this->normalizePublicAssetUrl($this->image_url);
    }
}
