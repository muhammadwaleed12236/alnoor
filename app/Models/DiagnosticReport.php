<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosticReport extends Model
{
    protected $fillable = [
        'report_id',
        'token_number',
        'mrn',
        'patient_name',
        'age',
        'gender',
        'doctor',
        'category',
        'test_name',
        'report_date',
        'status',
        'impression',
        'consultant',
    ];

    public function items()
    {
        return $this->hasMany(ReportItem::class);
    }
}
