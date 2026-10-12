<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'icon',
        'badge',
        'short_desc',
        'features',
        'opd_timings',
        'starting_fee',
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
