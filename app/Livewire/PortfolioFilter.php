<?php

namespace App\Livewire;

use Livewire\Component;

class PortfolioFilter extends Component
{
    public string $imgBase;

    public string $category = 'All';

    public array $categories = [
        'All',
        'Website',
        'Mobile App',
        'Dashboard',
        'Game',
        '3D Design',
    ];

    public array $projects = [
        [
            'title' => 'Astra Commerce',
            'category' => 'Website',
            'desc' => 'Website brand & product yang cepat, modern, dan SEO-friendly.',
            'stack' => ['Laravel', 'Tailwind', 'Vite'],
            'prompt' => 'premium modern website mockup on bright white background with subtle emerald and cyan gradients, clean landing page UI, glassmorphism cards, soft shadow, realistic screen mockup, high-end tech startup aesthetic, ultra detailed, studio lighting',
            'size' => 'landscape_16_9',
        ],
        [
            'title' => 'Pulse Mobile App',
            'category' => 'Mobile App',
            'desc' => 'Aplikasi mobile dengan UX elegan dan flow onboarding yang rapi.',
            'stack' => ['UI/UX', 'iOS/Android', 'API'],
            'prompt' => 'premium mobile app UI mockup, bright clean white background, emerald and cyan gradient accents, glassmorphism, modern rounded corners, realistic smartphone mockup, soft glow, high detail, studio lighting',
            'size' => 'landscape_16_9',
        ],
        [
            'title' => 'Insight Dashboard',
            'category' => 'Dashboard',
            'desc' => 'Dashboard analytics modern dengan visualisasi data yang jelas.',
            'stack' => ['Software', 'Analytics', 'Charts'],
            'prompt' => 'modern analytics dashboard UI on bright white background, green and cyan gradient accents, clean cards, charts, tables, glassmorphism, premium tech aesthetic, ultra realistic monitor mockup, soft shadows',
            'size' => 'landscape_16_9',
        ],
        [
            'title' => 'Nova Runner',
            'category' => 'Game',
            'desc' => 'Prototype game dengan visual futuristik dan animasi halus.',
            'stack' => ['Unity', '2D/3D', 'Gameplay'],
            'prompt' => 'futuristic premium game concept art on bright white background with subtle green and cyan gradients, character and UI overlay, clean modern style, soft glow, high detail, studio lighting',
            'size' => 'landscape_16_9',
        ],
        [
            'title' => '3D Product Render',
            'category' => '3D Design',
            'desc' => '3D modeling dan render produk dengan detail realistis.',
            'stack' => ['3D', 'Rendering', 'Material'],
            'prompt' => 'premium realistic 3d product render in bright studio, white background with subtle emerald and cyan gradient light, glass-like reflections, high detail, soft shadows, modern tech aesthetic',
            'size' => 'landscape_16_9',
        ],
        [
            'title' => 'SaaS Web Platform',
            'category' => 'Website',
            'desc' => 'Platform web dengan desain premium, modular, dan scalable.',
            'stack' => ['SaaS', 'Auth', 'Billing'],
            'prompt' => 'premium SaaS web app interface mockup, bright white background, green and cyan gradient highlights, glassmorphism panels, modern rounded corners, realistic laptop mockup, ultra detailed, studio lighting',
            'size' => 'landscape_16_9',
        ],
    ];

    public function mount(string $imgBase): void
    {
        $this->imgBase = $imgBase;
    }

    public function setCategory(string $category): void
    {
        $this->category = in_array($category, $this->categories, true) ? $category : 'All';
    }

    public function getFilteredProjectsProperty(): array
    {
        if ($this->category === 'All') {
            return $this->projects;
        }

        return array_values(array_filter($this->projects, fn ($p) => $p['category'] === $this->category));
    }

    public function render()
    {
        return view('livewire.portfolio-filter');
    }
}
