<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $guarded = ['id'];

    public const STATUSES = ['new', 'contacted', 'closed'];

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
