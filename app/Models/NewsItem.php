<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'event_date'   => 'date',
        'gallery'      => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeKind($query, string $kind)
    {
        return $query->where('kind', $kind);
    }
}
