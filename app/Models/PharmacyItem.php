<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyItem extends Model
{
    protected $fillable = [
        'name',
        'generic_name',
        'category',
        'stock_qty',
        'unit_price',
        'expiry_date',
    ];
}
