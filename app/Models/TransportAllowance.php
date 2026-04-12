<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportAllowance extends Model
{
    protected $fillable = ['employee_id', 'year', 'month', 'distance', 'working_days', 'amount'];

    protected $casts = [
        'distance' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the employee this allowance belongs to.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calculate transport allowance amount.
     * Formula: base_fare * rounded_distance * working_days (if working_days >= min_working_days)
     */
    public static function calculateAllowance($employee, $distance, $workingDays, $month, $year)
    {
        $settings = TransportAllowanceSetting::getActiveSettings();

        if (!$settings || $workingDays < $settings->min_working_days) {
            return 0;
        }

        if (!$employee->isEligibleForTransportAllowance()) {
            return 0;
        }

        // Check distance constraints
        if ($distance < $settings->min_distance || $distance > $settings->max_distance) {
            return 0;
        }

        if ($distance <= $settings->min_distance) {
            return 0;
        }

        // Round distance according to rules
        $roundedDistance = self::roundDistance($distance);

        return $settings->base_fare * $roundedDistance * $workingDays;
    }

    /**
     * Round distance according to rules:
     * - If decimal < 0.5 round down
     * - If decimal >= 0.5 round up
     */
    private static function roundDistance($distance)
    {
        $decimal = $distance - floor($distance);

        if ($decimal < 0.5) {
            return floor($distance);
        } else {
            return ceil($distance);
        }
    }
}
