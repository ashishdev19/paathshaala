<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get setting value with proper type casting.
     */
    public function getTypedValue()
    {
        return match($this->type) {
            'boolean' => $this->value === 'true' || $this->value === '1',
            'integer' => (int) $this->value,
            'decimal' => (float) $this->value,
            default => $this->value,
        };
    }

    /**
     * Get a setting by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return $setting->getTypedValue();
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
    }
}
