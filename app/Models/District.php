<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $fillable = ['name', 'province_id'];

    public $timestamps = true;

    /**
     * Get the province this district belongs to.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the sub-districts in this district.
     */
    public function subDistricts(): HasMany
    {
        return $this->hasMany(SubDistrict::class);
    }
}
