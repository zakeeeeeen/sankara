<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Http\UploadedFile;

class PageService
{
    public function getPageBySlug(string $slug): Page
    {
        /** @var Page */
        return Page::query()->where('slug', $slug)->firstOrFail();
    }

    public function getAboutPage(): Page
    {
        /** @var Page */
        return Page::query()->firstOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'title' => 'Tentang Kami',
                'hero_title' => 'Tentang Kami',
                'hero_subtitle' => 'Mengenal lebih dekat visi, misi, dan tim di balik produk digital kami.',
                'body' => 'Kami adalah tim yang berfokus pada pengembangan produk digital modern.',
            ]
        );
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updatePage(Page $page, array $data, ?UploadedFile $image = null): Page
    {
        if ($image instanceof UploadedFile) {
            $data['image_path'] = $image->store('pages', 'public');
        }

        $page->update($data);

        return $page;
    }
}
