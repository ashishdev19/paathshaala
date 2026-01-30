<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the referral code.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique referral code for a user.
     */
    public static function generateUniqueCode(User $user): string
    {
        $baseName = strtoupper(substr($user->name, 0, 4));
        $baseName = preg_replace('/[^A-Z]/', '', $baseName); // Remove non-alphabetic
        
        if (strlen($baseName) < 3) {
            $baseName = 'USER';
        }
        
        $attempt = 0;
        do {
            $randomSuffix = rand(1000, 9999);
            $code = $baseName . $randomSuffix;
            $attempt++;
            
            // Prevent infinite loop
            if ($attempt > 50) {
                $code = 'REF' . time() . rand(10, 99);
                break;
            }
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Create referral code for a user.
     */
    public static function createForUser(User $user): self
    {
        return self::create([
            'user_id' => $user->id,
            'code' => self::generateUniqueCode($user),
            'is_active' => true,
        ]);
    }

    /**
     * Check if code is valid and active.
     */
    public function isValid(): bool
    {
        return $this->is_active;
    }
}
