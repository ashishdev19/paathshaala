<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

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
        'profession_type',
        'city',
        'state',
        'pincode',
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

    public function customNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function unreadCustomNotifications()
    {
        return $this->hasMany(Notification::class, 'user_id')->where('is_read', false);
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
     * Filter users by role name
     */
    public function scopeByRole($query, $roleName)
    {
        return $query->role($roleName);
    }

    /**
     * Filter users by multiple role names
     */
    public function scopeByRoles($query, $roleNames)
    {
        return $query->role((array) $roleNames);
    }

    // ========================
    // ROLE HELPER METHODS
    // ========================

    /**
     * Check if user is Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('superadmin');
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is Instructor/Teacher
     */
    public function isInstructor(): bool
    {
        return $this->hasRole('instructor');
    }

    /**
     * Check if user is Student
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * Check if user has an active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->currentSubscription()->exists();
    }

    /**
     * Get the URL to the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_image && Storage::disk('public')->exists($this->profile_image)) {
            return asset('storage/' . $this->profile_image);
        }
        
        return null;
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}

