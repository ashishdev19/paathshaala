<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'module',
    ];

    /**
     * Get all roles that have this permission
     */
    public function roles()
    {
        return $this->belongsToMany(
            AdminRole::class,
            'admin_role_permission',
            'admin_permission_id',
            'admin_role_id'
        )->withTimestamps();
    }

    /**
     * Group permissions by module
     */
    public function scopeGroupedByModule($query)
    {
        return $query->orderBy('module')->orderBy('name')->get()->groupBy('module');
    }
}
