<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::saving(function (Model $model) {
            $source = $model->slugSource();

            if (blank($model->slug) && filled($source)) {
                $model->slug = static::generateUniqueSlug($model, $source);
            } elseif ($model->isDirty('slug')) {
                $model->slug = Str::slug($model->slug);
            }
        });
    }

    protected function slugSource(): string
    {
        return (string) ($this->title ?? $this->name ?? '');
    }

    protected static function generateUniqueSlug(Model $model, string $value): string
    {
        $base = Str::slug($value) ?: Str::random(8);
        $slug = $base;
        $i = 2;

        while (static::slugExists($model, $slug)) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    protected static function slugExists(Model $model, string $slug): bool
    {
        $query = $model->newQueryWithoutScopes()->where('slug', $slug);

        if ($model->getKey()) {
            $query->whereKeyNot($model->getKey());
        }

        return $query->exists();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
