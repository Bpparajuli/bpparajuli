<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experience extends Model
{
    use Publishable, SoftDeletes;

    protected $fillable = [
        'organization',
        'position',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'responsibilities',
        'achievements',
        'organization_url',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'responsibilities' => 'array',
            'achievements' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function periodLabel(): string
    {
        $start = $this->start_date?->format('M Y') ?? '—';
        $end = $this->is_current
            ? 'Present'
            : ($this->end_date?->format('M Y') ?? '—');

        return $start.' — '.$end;
    }
}
