<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasSlug, Publishable, SoftDeletes;

    public const STATUSES = [
        'concept' => 'Concept',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'ongoing' => 'Ongoing',
        'archived' => 'Archived',
    ];

    protected $fillable = [
        'project_category_id',
        'title',
        'slug',
        'subtitle',
        'short_description',
        'overview',
        'problem',
        'approach',
        'solution',
        'result',
        'role',
        'client',
        'timeline',
        'technologies',
        'status',
        'featured_image',
        'external_url',
        'github_url',
        'is_featured',
        'is_active',
        'sort_order',
        'seo_title',
        'seo_description',
        'og_image',
        'canonical_url',
    ];

    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function related(int $limit = 3)
    {
        return static::query()
            ->published()
            ->whereKeyNot($this->getKey())
            ->when($this->project_category_id, fn ($q) => $q->where('project_category_id', $this->project_category_id))
            ->ordered()
            ->limit($limit)
            ->get();
    }
}
