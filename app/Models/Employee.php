<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['nip', 'name', 'email', 'phone', 'place_of_birth', 'sub_district_id', 'district_id', 'province_id', 'address', 'date_of_birth', 'marital_status', 'number_of_children', 'start_date', 'employment_type', 'position_id', 'department_id', 'age', 'is_active'];

    protected $casts = [
        'date_of_birth' => 'date',
        'start_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the position of this employee.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the department of this employee.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the sub-district of this employee.
     */
    public function subDistrict(): BelongsTo
    {
        return $this->belongsTo(SubDistrict::class);
    }

    /**
     * Get the district of this employee.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the province of this employee.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the education history for this employee.
     */
    public function education(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    /**
     * Get the transport allowances for this employee.
     */
    public function transportAllowances(): HasMany
    {
        return $this->hasMany(TransportAllowance::class);
    }

    /**
     * Calculate years of service.
     */
    public function getYearsOfService()
    {
        return now()->diffInYears($this->start_date);
    }

    /**
     * Check if employee is eligible for transport allowance.
     */
    public function isEligibleForTransportAllowance(): bool
    {
        return $this->employment_type === 'tetap';
    }
}
