<?php

namespace App\Support;

use App\Models\NavigationLink;
use App\Models\SocialLink;
use Illuminate\Support\Collection;

class SiteData
{
    /**
     * @var array<string, mixed>
     */
    protected static array $memo = [];

    /**
     * @return Collection<int, NavigationLink>
     */
    public static function navigation(string $group = 'header'): Collection
    {
        return self::$memo['nav.'.$group] ??= NavigationLink::query()
            ->group($group)
            ->active()
            ->ordered()
            ->get();
    }

    /**
     * @return Collection<int, SocialLink>
     */
    public static function social(): Collection
    {
        return self::$memo['social'] ??= SocialLink::query()
            ->active()
            ->ordered()
            ->get();
    }

    public static function profile(string $key, mixed $default = null): mixed
    {
        $profile = self::$memo['profile'] ??= [
            'name' => setting('profile_name', setting('site_name', config('app.name'))),
            'headline' => setting('profile_headline'),
            'short_bio' => setting('profile_short_bio'),
            'bio' => setting('profile_bio'),
            'image' => setting('profile_image'),
            'location' => setting('profile_location'),
            'email' => setting('contact_email'),
            'phone' => setting('contact_phone'),
            'availability' => setting('profile_availability'),
            'current_focus' => setting('profile_current_focus'),
            'resume' => setting('profile_resume'),
        ];

        return $profile[$key] ?? $default;
    }

    public static function flush(): void
    {
        self::$memo = [];
    }
}
