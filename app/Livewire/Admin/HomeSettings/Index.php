<?php

namespace App\Livewire\Admin\HomeSettings;

use App\Services\HomeService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class Index extends Component
{
    use WithFileUploads;

    public array $hero = [
        'heading' => '',
        'subheading' => '',
        'primary_cta_label' => '',
        'primary_cta_url' => '',
        'secondary_cta_label' => '',
        'secondary_cta_url' => '',
    ];

    public mixed $hero_image = null;

    public ?string $existingHeroImage = null;

    public array $about = [
        'body' => '',
    ];

    public mixed $about_image = null;

    public ?string $existingAboutImage = null;

    public array $cta = [
        'heading' => '',
        'body' => '',
        'primary_label' => '',
        'primary_url' => '',
        'secondary_label' => '',
        'secondary_url' => '',
    ];

    public array $stats = [];

    public array $advantages = [];

    public array $contact = [
        'email' => '',
        'whatsapp' => '',
        'address' => '',
        'hours' => '',
        'inbox_email' => '',
        'map_embed_url' => '',
    ];

    public array $socials = [
        'instagram' => '',
        'linkedin' => '',
        'dribbble' => '',
        'tiktok' => '',
        'twitter' => '',
        'discord' => '',
        'whatsapp' => '',
        'github' => '',
        'youtube' => '',
    ];

    public function mount(HomeService $homeService): void
    {
        $data = $homeService->getAdminHomeEditData();

        if ($data['hero']) {
            $this->hero = [
                'heading' => (string) ($data['hero']->heading ?? ''),
                'subheading' => (string) ($data['hero']->subheading ?? ''),
                'primary_cta_label' => (string) ($data['hero']->primary_cta_label ?? ''),
                'primary_cta_url' => (string) ($data['hero']->primary_cta_url ?? ''),
                'secondary_cta_label' => (string) ($data['hero']->secondary_cta_label ?? ''),
                'secondary_cta_url' => (string) ($data['hero']->secondary_cta_url ?? ''),
            ];
            $this->existingHeroImage = $data['hero']->image_src;
        }

        if ($data['about']) {
            $this->about = [
                'body' => (string) ($data['about']->body ?? ''),
            ];
            $this->existingAboutImage = $data['about']->image_src;
        }

        if ($data['cta']) {
            $this->cta = [
                'heading' => (string) ($data['cta']->heading ?? ''),
                'body' => (string) ($data['cta']->body ?? ''),
                'primary_label' => (string) ($data['cta']->primary_label ?? ''),
                'primary_url' => (string) ($data['cta']->primary_url ?? ''),
                'secondary_label' => (string) ($data['cta']->secondary_label ?? ''),
                'secondary_url' => (string) ($data['cta']->secondary_url ?? ''),
            ];
        }

        $this->stats = $data['stats']->map(fn ($s) => [
            'value' => $s->value,
            'label' => $s->label,
        ])->all();

        if (empty($this->stats)) {
            $this->stats = [
                ['value' => '10+', 'label' => 'Tahun Pengalaman'],
                ['value' => '50+', 'label' => 'Proyek Selesai'],
                ['value' => '99%', 'label' => 'Klien Puas'],
            ];
        }

        $this->advantages = $data['advantages']->map(fn ($a) => [
            'title' => $a->title,
            'description' => $a->description,
        ])->all();

        $this->contact = array_merge($this->contact, (array) $data['contact']);
        $this->socials = array_merge($this->socials, (array) $data['socials']);
    }

    public function addStat(): void
    {
        $this->stats[] = ['value' => '', 'label' => ''];
    }

    public function removeStat(int $index): void
    {
        unset($this->stats[$index]);
        $this->stats = array_values($this->stats);
    }

    public function addAdvantage(): void
    {
        $this->advantages[] = ['title' => '', 'description' => ''];
    }

    public function removeAdvantage(int $index): void
    {
        unset($this->advantages[$index]);
        $this->advantages = array_values($this->advantages);
    }

    public function save(HomeService $homeService): void
    {
        $this->validate([
            'hero.heading' => ['required', 'string', 'max:255'],
            'hero.subheading' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
            'about.body' => ['nullable', 'string'],
            'about_image' => ['nullable', 'image', 'max:4096'],
            'cta.heading' => ['required', 'string', 'max:255'],
            'cta.body' => ['nullable', 'string'],
            'stats.*.value' => ['required', 'string', 'max:64'],
            'stats.*.label' => ['required', 'string', 'max:128'],
            'advantages.*.title' => ['required', 'string', 'max:255'],
        ]);

        $files = [];
        if ($this->hero_image) {
            $files['hero_image'] = $this->hero_image;
        }
        if ($this->about_image) {
            $files['about_image'] = $this->about_image;
        }

        $homeService->updateHomeContent([
            'hero' => $this->hero,
            'about' => $this->about,
            'cta' => $this->cta,
            'stats' => $this->stats,
            'advantages' => $this->advantages,
            'contact' => $this->contact,
            'socials' => $this->socials,
        ], $files);

        session()->flash('status', 'Pengaturan Beranda (Home) berhasil disimpan.');
    }

    public function render(): View
    {
        return view('livewire.admin.home-settings');
    }
}
