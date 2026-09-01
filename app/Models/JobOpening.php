<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOpening extends Model
{
    protected $table = 'job_openings';

    protected $guarded = ['id'];

    protected $casts = [
        'responsibilities' => 'array',
        'requirements'     => 'array',
        'benefits'         => 'array',
        'is_open'          => 'boolean',
        'posted_at'        => 'date',
        'closing_at'       => 'date',
    ];

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
