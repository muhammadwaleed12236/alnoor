<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'mr_number',
        'name',
        'age',
        'gender',
        'phone',
        'address',
        'medical_notes',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
