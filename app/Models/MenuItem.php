<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $guarded = ['id'];

    public const MENUS = ['header' => 'Header', 'footer' => 'Footer'];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeMenu($query, string $menu)
    {
        return $query->where('menu', $menu);
    }

    /** Resolved link: explicit url wins, else the linked page, else "#". */
    public function resolvedUrl(): string
    {
        if (filled($this->url)) {
            return $this->url;
        }

        return $this->page ? $this->page->url() : '#';
    }
}
