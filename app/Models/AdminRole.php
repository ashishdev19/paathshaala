<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all accounts with this role
     */
    public function accounts()
    {
        return $this->hasMany(AdminAccount::class, 'admin_role_id');
    }

    /**
     * Get all permissions for this role
     */
    public function permissions()
    {
        return $this->belongsToMany(
            AdminPermission::class,
            'admin_role_permission',
            'admin_role_id',
            'admin_permission_id'
        )->withTimestamps();
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permissionSlug)
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }

    /**
     * Sync permissions to this role
     */
    public function syncPermissions(array $permissionIds)
    {
        return $this->permissions()->sync($permissionIds);
    }

    /**
     * Get active roles only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
