<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'profile_image',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'student_id');
    }

    // Teacher Subscription Relationships
    public function teacherEnquiry()
    {
        return $this->hasOne(TeacherEnquiry::class, 'user_id');
    }

    public function teacherEnquiries()
    {
        return $this->hasMany(TeacherEnquiry::class, 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(TeacherSubscription::class, 'user_id');
    }

    public function currentSubscription()
    {
        return $this->hasOne(TeacherSubscription::class, 'user_id')
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->latest();
    }

    public function subscriptionHistory()
    {
        return $this->hasMany(TeacherSubscriptionHistory::class, 'user_id');
    }

    // Wallet Relationships
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function withdrawRequests()
    {
        return $this->hasMany(WithdrawRequest::class, 'teacher_id');
    }

    public function walletTopups()
    {
        return $this->hasMany(WalletTopup::class, 'student_id');
    }

    /**
     * Get or create wallet for user
     */
    public function getOrCreateWallet()
    {
        if (!$this->wallet) {
            $this->wallet()->create([
                'balance' => 0,
                'currency' => 'INR',
                'reserved_amount' => 0,
            ]);
        }
        return $this->wallet;
    }

    // ========================
    // ROLE HELPER METHODS
    // ========================

    // ========================
    // QUERY SCOPES
    // ========================

    /**
     * Filter users by role slug
     */
    public function scopeByRole($query, $roleSlug)
    {
        return $query->whereHas('role', function ($q) use ($roleSlug) {
            $q->where('slug', $roleSlug);
        });
    }

    /**
     * Filter users by multiple role slugs
     */
    public function scopeByRoles($query, $roleSlugs)
    {
        return $query->whereHas('role', function ($q) use ($roleSlugs) {
            $q->whereIn('slug', (array) $roleSlugs);
        });
    }

    // ========================
    // ROLE HELPER METHODS
    // ========================

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role?->slug === 'superadmin';
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role?->slug === 'admin';
    }

    /**
     * Check if user is Instructor/Teacher
     */
    public function isInstructor(): bool
    {
        return $this->role?->slug === 'instructor';
    }

    /**
     * Check if user is Student
     */
    public function isStudent(): bool
    {
        return $this->role?->slug === 'student';
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleSlug): bool
    {
        if (is_array($roleSlug)) {
            return in_array($this->role?->slug, $roleSlug);
        }
        return $this->role?->slug === $roleSlug;
    }

    /**
     * Check if user has permission
     */
    public function hasPermission($permission): bool
    {
        if (!$this->role) {
            return false;
        }
        return $this->role->hasPermission($permission);
    }

    /**
     * Assign role to user
     */
    public function assignRole($role): self
    {
        if (is_string($role)) {
            $role = Role::whereSlug($role)->firstOrFail();
        }

        $this->update(['role_id' => $role->id]);
        return $this;
    }
}

