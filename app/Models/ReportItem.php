<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportItem extends Model
{
    protected $fillable = [
        'diagnostic_report_id',
        'param',
        'value',
        'normal_range',
    ];

    public function report()
    {
        return $this->belongsTo(DiagnosticReport::class, 'diagnostic_report_id');
    }
}
