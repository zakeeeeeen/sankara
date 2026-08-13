<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function edit(Request $request)
    {
        $page = Page::query()->where('slug', 'tentang-kami')->firstOrFail();

        return view('admin.pages.about', compact('page'));
    }

    public function update(Request $request)
    {
        $page = Page::query()->where('slug', 'tentang-kami')->firstOrFail();

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $page->fill($data);

        if ($request->hasFile('image')) {
            $page->image_path = $request->file('image')->store('pages', 'public');
        }

        $page->save();

        return redirect()->route('admin.pages.about.edit')->with('status', 'Halaman diperbarui.');
    }
}

