<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'rating'       => 'integer',
        'is_published' => 'boolean',
        'sort_order'   => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function initial(): string
    {
        return Str::upper(Str::substr(trim($this->avatar ?: $this->name), 0, 1)) ?: '★';
    }

    public function stars(): int
    {
        return max(1, min(5, (int) $this->rating));
    }
}
