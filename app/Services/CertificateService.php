<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class CertificateService
{
    /**
     * Generate certificate for student
     */
    public static function generateCertificate(User $student, Course $course): Certificate
    {
        // Check if student has completed the course
        $enrollment = Enrollment::where('student_id', $student->id)
                               ->where('course_id', $course->id)
                               ->where('status', 'completed')
                               ->first();

        if (!$enrollment) {
            throw new \Exception('Student has not completed this course');
        }

        // Check if certificate already exists
        $existingCertificate = Certificate::where('student_id', $student->id)
                                        ->where('course_id', $course->id)
                                        ->first();

        if ($existingCertificate) {
            return $existingCertificate;
        }

        // Generate certificate
        $certificateData = [
            'student_id' => $student->id,
            'course_id' => $course->id,
            'certificate_number' => self::generateCertificateNumber(),
            'issued_date' => now(),
            'completion_date' => $enrollment->completed_at ?? now(),
            'grade' => self::calculateGrade($enrollment),
            'verification_code' => Str::random(16),
            'is_verified' => true,
        ];

        $certificate = Certificate::create($certificateData);

        // Generate PDF
        $pdfPath = self::generateCertificatePDF($certificate);
        $certificate->update(['file_path' => $pdfPath]);

        return $certificate;
    }

    /**
     * Generate unique certificate number
     */
    private static function generateCertificateNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $random = strtoupper(Str::random(6));
        
        return "CERT-{$year}{$month}-{$random}";
    }

    /**
     * Calculate grade based on enrollment data
     */
    private static function calculateGrade(Enrollment $enrollment): string
    {
        // For now, return a simple grade
        // In a real system, this would be based on assessments, completion percentage, etc.
        $completionPercentage = 100; // Assume 100% since course is completed
        
        if ($completionPercentage >= 95) {
            return 'A+';
        } elseif ($completionPercentage >= 90) {
            return 'A';
        } elseif ($completionPercentage >= 85) {
            return 'B+';
        } elseif ($completionPercentage >= 80) {
            return 'B';
        } elseif ($completionPercentage >= 75) {
            return 'C+';
        } elseif ($completionPercentage >= 70) {
            return 'C';
        } else {
            return 'Pass';
        }
    }

    /**
     * Generate certificate PDF
     */
    private static function generateCertificatePDF(Certificate $certificate): string
    {
        // Create certificate content as HTML (simplified version)
        $html = self::generateCertificateHTML($certificate);
        
        // In a real implementation, you would use a PDF library like TCPDF or FPDF
        // For now, we'll create a simple HTML file that can be converted to PDF
        $filename = 'certificate_' . $certificate->certificate_number . '.html';
        $path = 'certificates/' . $filename;
        
        Storage::disk('public')->put($path, $html);
        
        return $path;
    }

    /**
     * Generate certificate HTML content
     */
    private static function generateCertificateHTML(Certificate $certificate): string
    {
        $student = $certificate->student;
        $course = $certificate->course;
        $teacher = $course->teacher;
        
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
        }
        .certificate {
            background: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 8px solid #d4af37;
            position: relative;
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #d4af37;
            pointer-events: none;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .subtitle {
            font-size: 24px;
            color: #666;
            margin-bottom: 40px;
        }
        .content {
            text-align: center;
            margin-bottom: 40px;
        }
        .student-name {
            font-size: 42px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            text-decoration: underline;
            text-decoration-color: #d4af37;
        }
        .course-info {
            font-size: 20px;
            color: #666;
            margin: 20px 0;
            line-height: 1.6;
        }
        .course-title {
            font-weight: bold;
            color: #333;
            font-size: 24px;
        }
        .completion-text {
            font-size: 18px;
            color: #666;
            margin: 30px 0;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 60px;
            padding-top: 20px;
            border-top: 2px solid #d4af37;
        }
        .signature-section {
            text-align: center;
            flex: 1;
        }
        .signature-line {
            border-bottom: 2px solid #333;
            width: 200px;
            margin: 0 auto 10px;
            height: 50px;
        }
        .signature-label {
            font-size: 14px;
            color: #666;
        }
        .certificate-info {
            text-align: right;
            font-size: 12px;
            color: #999;
        }
        .grade {
            font-size: 24px;
            font-weight: bold;
            color: #d4af37;
            margin: 10px 0;
        }
        .decorative-border {
            position: absolute;
            width: 100px;
            height: 100px;
            opacity: 0.1;
        }
        .decorative-border.top-left {
            top: 40px;
            left: 40px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="%23d4af37"/></svg>');
        }
        .decorative-border.top-right {
            top: 40px;
            right: 40px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="%23d4af37"/></svg>');
        }
        .decorative-border.bottom-left {
            bottom: 40px;
            left: 40px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="%23d4af37"/></svg>');
        }
        .decorative-border.bottom-right {
            bottom: 40px;
            right: 40px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="%23d4af37"/></svg>');
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="decorative-border top-left"></div>
        <div class="decorative-border top-right"></div>
        <div class="decorative-border bottom-left"></div>
        <div class="decorative-border bottom-right"></div>
        
        <div class="header">
            <div class="logo">PAATHSHAALA</div>
            <div class="title">Certificate of Completion</div>
            <div class="subtitle">This certifies that</div>
        </div>
        
        <div class="content">
            <div class="student-name">{$student->name}</div>
            
            <div class="completion-text">
                has successfully completed the online course
            </div>
            
            <div class="course-info">
                <div class="course-title">"{$course->title}"</div>
                <div>Instructed by <strong>{$teacher->name}</strong></div>
                <div>Duration: {$course->duration} hours</div>
                <div>Completed on: {$certificate->completion_date->format('F j, Y')}</div>
            </div>
            
            <div class="grade">Grade: {$certificate->grade}</div>
        </div>
        
        <div class="footer">
            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-label">Instructor</div>
                <div>{$teacher->name}</div>
            </div>
            
            <div class="signature-section">
                <div class="signature-line"></div>
                <div class="signature-label">Director</div>
                <div>Paathshaala Learning Platform</div>
            </div>
            
            <div class="certificate-info">
                <div>Certificate No: {$certificate->certificate_number}</div>
                <div>Issue Date: {$certificate->issued_date->format('F j, Y')}</div>
                <div>Verification Code: {$certificate->verification_code}</div>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    }

    /**
     * Verify certificate by verification code
     */
    public static function verifyCertificate(string $verificationCode): ?Certificate
    {
        return Certificate::where('verification_code', $verificationCode)
                         ->where('is_verified', true)
                         ->first();
    }

    /**
     * Generate bulk certificates for course
     */
    public static function generateBulkCertificates(Course $course): array
    {
        $completedEnrollments = Enrollment::where('course_id', $course->id)
                                        ->where('status', 'completed')
                                        ->with('student')
                                        ->get();

        $certificates = [];

        foreach ($completedEnrollments as $enrollment) {
            try {
                $certificate = self::generateCertificate($enrollment->student, $course);
                $certificates[] = $certificate;
            } catch (\Exception $e) {
                // Log error but continue with other certificates
                \Log::error("Failed to generate certificate for student {$enrollment->student_id}: {$e->getMessage()}");
            }
        }

        return $certificates;
    }

    /**
     * Revoke certificate
     */
    public static function revokeCertificate(Certificate $certificate): bool
    {
        $certificate->update([
            'is_verified' => false,
            'revoked_at' => now(),
        ]);

        // Delete the file if it exists
        if ($certificate->file_path && Storage::disk('public')->exists($certificate->file_path)) {
            Storage::disk('public')->delete($certificate->file_path);
        }

        return true;
    }

    /**
     * Get certificate statistics
     */
    public static function getCertificateStats(): array
    {
        return [
            'total_issued' => Certificate::count(),
            'this_month' => Certificate::whereMonth('issued_date', now()->month)
                                     ->whereYear('issued_date', now()->year)
                                     ->count(),
            'verified' => Certificate::where('is_verified', true)->count(),
            'by_course' => Certificate::selectRaw('course_id, COUNT(*) as count')
                                    ->with('course:id,title')
                                    ->groupBy('course_id')
                                    ->get()
                                    ->pluck('count', 'course.title'),
        ];
    }
}