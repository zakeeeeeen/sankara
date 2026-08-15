<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value'])]
class SiteSetting extends Model
{
    public const CACHE_KEY = 'site_settings_all';

    protected static function booted(): void
    {
        static::saved(function (): void {
            static::clearCache();
        });

        static::deleted(function (): void {
            static::clearCache();
        });
    }

    /**
     * Clear the cached site settings.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Get all settings from cache or database.
     *
     * @return array<string, mixed>
     */
    public static function getAllCached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            $settings = [];
            $rows = static::query()->get(['key', 'value']);

            foreach ($rows as $row) {
                if ($row->value === null) {
                    $settings[$row->key] = null;

                    continue;
                }

                $decoded = json_decode($row->value, true);
                $settings[$row->key] = json_last_error() === JSON_ERROR_NONE ? $decoded : $row->value;
            }

            return $settings;
        });
    }

    /**
     * Get a setting value with an optional fallback.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $all = static::getAllCached();

        if (array_key_exists($key, $all) && $all[$key] !== null) {
            return $all[$key];
        }

        return $default;
    }

    /**
     * Set a setting value and invalidate cache.
     */
    public static function setValue(string $key, mixed $value): void
    {
        $payload = is_string($value) ? $value : json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $payload],
        );

        static::clearCache();
    }
}
