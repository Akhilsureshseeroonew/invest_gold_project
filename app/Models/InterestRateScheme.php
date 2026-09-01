<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestRateScheme extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'columns'    => 'array',
        'rows'       => 'array',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
