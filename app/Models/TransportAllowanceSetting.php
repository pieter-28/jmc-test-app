<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportAllowanceSetting extends Model
{
    protected $fillable = ['base_fare', 'min_distance', 'max_distance', 'min_working_days', 'effective_date'];

    protected $casts = [
        'effective_date' => 'datetime',
        'base_fare' => 'decimal:2',
        'min_distance' => 'decimal:2',
        'max_distance' => 'decimal:2',
    ];

    /**
     * Get the latest effective settings.
     */
    public static function getActiveSettings()
    {
        return self::where('effective_date', '<=', now())->latest('effective_date')->first();
    }
}
