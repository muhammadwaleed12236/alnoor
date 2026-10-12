<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenQueue extends Model
{
    protected $fillable = [
        'token_number',
        'patient_name',
        'phone',
        'service',
        'queue_time',
        'status',
    ];
}
