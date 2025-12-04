<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class AdminAccount extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin_role_id',
        'phone',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Get the role of this admin account
     */
    public function role()
    {
        return $this->belongsTo(AdminRole::class, 'admin_role_id');
    }

    /**
     * Get all permissions through role
     */
    public function permissions()
    {
        if (!$this->role) {
            return collect([]);
        }
        return $this->role->permissions;
    }

    /**
     * Check if account has a specific permission
     */
    public function hasPermission($permissionSlug)
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->hasPermission($permissionSlug);
    }

    /**
     * Check if account has any of the given permissions
     */
    public function hasAnyPermission(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if account has all given permissions
     */
    public function hasAllPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get active accounts only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get accounts by role
     */
    public function scopeByRole($query, $roleId)
    {
        return $query->where('admin_role_id', $roleId);
    }

    /**
     * Set password attribute
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
