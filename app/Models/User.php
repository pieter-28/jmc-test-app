<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'username', 'phone', 'password', 'role_id', 'is_active', 'last_login_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the activity logs for this user.
     */
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if user has permission.
     */
    public function hasPermission($permissionSlug)
    {
        // If there's no role_id, no permissions
        if (!$this->role_id) {
            return false;
        }

        // 1. Bypass by ID (usually 1 is superadmin)
        if ($this->role_id == 1) {
            return true;
        }

        // 2. Try to get role using relationship or direct query
        $role = $this->role;
        if (!$role) {
            $role = \App\Models\Role::find($this->role_id);
        }

        if (!$role) {
            return false;
        }

        // 3. Bypass by slug
        if ($role->slug === 'superadmin') {
            return true;
        }

        // 4. Standard permission check
        return $role->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission($permissionSlugs)
    {
        if (!$this->role) {
            return false;
        }

        if ($this->role->slug === 'superadmin') {
            return true;
        }

        return $this->role->permissions()->whereIn('slug', $permissionSlugs)->exists();
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions($permissionSlugs)
    {
        if (!$this->role) {
            return false;
        }

        if ($this->role->slug === 'superadmin') {
            return true;
        }

        $count = $this->role->permissions()->whereIn('slug', $permissionSlugs)->count();
        return $count === count($permissionSlugs);
    }
}
