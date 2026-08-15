<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServiceFeature;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceService
{
    /**
     * @return Collection<int, Service>
     */
    public function getActiveServices(): Collection
    {
        return Service::query()->active()->orderBy('sort_order')->get();
    }

    public function getServiceBySlug(string $slug): Service
    {
        /** @var Service */
        return Service::query()
            ->active()
            ->where('slug', $slug)
            ->with(['features', 'portfolioCategories'])
            ->firstOrFail();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function createService(array $data, ?UploadedFile $image = null): Service
    {
        return DB::transaction(function () use ($data, $image): Service {
            $serviceData = $data['service'] ?? [];
            if (! filled($serviceData['slug'] ?? null)) {
                $serviceData['slug'] = Str::slug($serviceData['title'] ?? '');
            }
            $serviceData['is_active'] = (bool) ($serviceData['is_active'] ?? false);

            if ($image instanceof UploadedFile) {
                $serviceData['image_path'] = $image->store('services', 'public');
            }

            /** @var Service $service */
            $service = Service::query()->create($serviceData);

            if (isset($data['portfolio_category_ids'])) {
                $service->portfolioCategories()->sync((array) $data['portfolio_category_ids']);
            }

            foreach (($data['features'] ?? []) as $i => $feat) {
                if (! filled($feat['text'] ?? null)) {
                    continue;
                }
                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => $feat['text'],
                    'sort_order' => $i + 1,
                ]);
            }

            return $service;
        });
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateService(Service $service, array $data, ?UploadedFile $image = null): Service
    {
        return DB::transaction(function () use ($service, $data, $image): Service {
            $serviceData = $data['service'] ?? [];
            if (! filled($serviceData['slug'] ?? null)) {
                $serviceData['slug'] = Str::slug($serviceData['title'] ?? '');
            }
            $serviceData['is_active'] = (bool) ($serviceData['is_active'] ?? false);

            if ($image instanceof UploadedFile) {
                $serviceData['image_path'] = $image->store('services', 'public');
            }

            $service->update($serviceData);

            $service->portfolioCategories()->sync((array) ($data['portfolio_category_ids'] ?? []));

            $service->features()->delete();
            foreach (($data['features'] ?? []) as $i => $feat) {
                if (! filled($feat['text'] ?? null)) {
                    continue;
                }
                ServiceFeature::query()->create([
                    'service_id' => $service->id,
                    'text' => $feat['text'],
                    'sort_order' => $i + 1,
                ]);
            }

            return $service;
        });
    }

    public function deleteService(Service $service): bool
    {
        return (bool) $service->delete();
    }
}
