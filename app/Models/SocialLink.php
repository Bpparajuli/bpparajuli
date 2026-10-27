<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use Publishable;

    protected $fillable = [
        'platform',
        'label',
        'url',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function displayLabel(): string
    {
        return $this->label ?: ucfirst($this->platform);
    }
}
