<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $course;
    public $enrollment;

    /**
     * Create a new message instance.
     */
    public function __construct(User $student, Course $course, Enrollment $enrollment)
    {
        $this->student = $student;
        $this->course = $course;
        $this->enrollment = $enrollment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to ' . $this->course->title . ' - Enrollment Confirmed!')
                    ->view('emails.enrollment-confirmation')
                    ->with([
                        'studentName' => $this->student->name,
                        'courseTitle' => $this->course->title,
                        'teacherName' => $this->course->teacher->name,
                        'courseDuration' => $this->course->duration,
                        'enrollmentDate' => $this->enrollment->created_at->format('F j, Y'),
                        'courseUrl' => route('student.courses.show', $this->course->id),
                        'dashboardUrl' => route('student.dashboard'),
                    ]);
    }
}