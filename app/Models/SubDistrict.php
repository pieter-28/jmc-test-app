<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubDistrict extends Model
{
    protected $fillable = ['name', 'district_id'];

    public $timestamps = true;

    /**
     * Get the district this sub-district belongs to.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the employees in this sub-district.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
