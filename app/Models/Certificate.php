<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'enrollment_id',
        'certificate_number',
        'issued_date',
        'certificate_file',
        'remarks',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    // Generate certificate number
    public static function generateCertificateNumber()
    {
        $year = date('Y');
        $lastCert = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $nextNumber = $lastCert ? (intval(substr($lastCert->certificate_number, -4)) + 1) : 1;
        
        return 'CERT-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
