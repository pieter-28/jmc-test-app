<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Get the users for this role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the permissions for this role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Grant a permission to this role.
     */
    public function grantPermission(Permission $permission)
    {
        $this->permissions()->syncWithoutDetaching($permission);
    }

    /**
     * Revoke a permission from this role.
     */
    public function revokePermission(Permission $permission)
    {
        $this->permissions()->detach($permission);
    }

    /**
     * Check if role has permission.
     */
    public function hasPermission($permissionSlug): bool
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }
}
