<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'token_number',
        'patient_id',
        'patient_name',
        'patient_phone',
        'patient_age',
        'patient_gender',
        'service_name',
        'doctor_name',
        'appointment_date',
        'slot',
        'status',
        'fee',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
