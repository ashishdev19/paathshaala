<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $table = 'teachers';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        // 'country_flag',
        'profile_image',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];
}
