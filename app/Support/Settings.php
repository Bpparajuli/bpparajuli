<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class Settings
{
    public const CACHE_KEY = 'site_settings.all';

    /**
     * @var array<string, mixed>|null
     */
    protected static ?array $memo = null;

    /**
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        if (self::$memo !== null) {
            return self::$memo;
        }

        try {
            return self::$memo = Cache::rememberForever(self::CACHE_KEY, function () {
                return SiteSetting::query()
                    ->get()
                    ->mapWithKeys(fn (SiteSetting $setting) => [$setting->key => $setting->typedValue()])
                    ->all();
            });
        } catch (\Throwable) {
            self::$memo = [];

            return self::$memo;
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = self::all()[$key] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): void
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
            $type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'boolean';
        }

        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type],
        );

        self::flush();
    }

    /**
     * @param  array<string, mixed>  $values
     */
    public static function setMany(array $values, string $group = 'general'): void
    {
        foreach ($values as $key => $value) {
            self::set($key, $value, $group);
        }

        self::flush();
    }

    public static function flush(): void
    {
        self::$memo = null;
        Cache::forget(self::CACHE_KEY);
    }
}
