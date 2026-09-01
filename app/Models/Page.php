<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'hero_ctas'    => 'array',
        'features'     => 'array',
        'steps'        => 'array',
        'highlights'   => 'array',
        'stats'        => 'array',
        'featured'     => 'boolean',
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /** Direct child pages ("products/gold-loan" is a child of "products"). */
    public function scopeChildrenOf($query, string $parentSlug)
    {
        return $query->where('slug', 'like', $parentSlug.'/%')
            ->whereRaw("slug NOT LIKE ?", [$parentSlug.'/%/%'])
            ->orderBy('sort_order');
    }

    /** Public URL for this page ("/" for home, "/slug" otherwise). */
    public function url(): string
    {
        return $this->slug === 'home' ? url('/') : url('/'.ltrim($this->slug, '/'));
    }
}
