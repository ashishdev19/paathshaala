<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon',
        'status',
        'show_on_homepage',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'show_on_homepage' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get all courses in this category.
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include categories shown on homepage.
     */
    public function scopeShowOnHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    /**
     * Get the icon class for the category.
     * Returns a default icon if none is set.
     */
    public function getIconClassAttribute(): string
    {
        if ($this->icon) {
            return $this->icon;
        }

        // Default icon mapping based on category name
        $iconMap = [
            'cardiology' => 'fa-heart-pulse',
            'clinical' => 'fa-syringe',
            'dermatology' => 'fa-prescription-bottle',
            'diabetes' => 'fa-notes-medical',
            'endocrinology' => 'fa-notes-medical',
            'gastroenterology' => 'fa-stomach',
            'mental' => 'fa-brain',
            'musculoskeletal' => 'fa-bone',
            'neurology' => 'fa-head-side-virus',
            'paediatric' => 'fa-baby',
            'pediatric' => 'fa-baby',
            'professional' => 'fa-user-graduate',
            'respiratory' => 'fa-lungs',
            'ent' => 'fa-ear-listen',
            'women' => 'fa-venus',
            'surgery' => 'fa-scissors',
            'emergency' => 'fa-truck-medical',
            'radiology' => 'fa-x-ray',
            'pathology' => 'fa-microscope',
            'pharmacology' => 'fa-pills',
            'psychiatry' => 'fa-brain',
            'oncology' => 'fa-ribbon',
            'ophthalmology' => 'fa-eye',
            'orthopedics' => 'fa-crutch',
        ];

        $lowerName = strtolower($this->name);
        
        foreach ($iconMap as $keyword => $icon) {
            if (str_contains($lowerName, $keyword)) {
                return $icon;
            }
        }

        return 'fa-stethoscope'; // Default icon
    }
}
