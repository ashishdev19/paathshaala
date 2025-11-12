<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Create a new notification
     */
    public static function create(array $data): Notification
    {
        return Notification::create([
            'type' => $data['type'],
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'data' => $data['data'] ?? null,
            'action_url' => $data['action_url'] ?? null,
            'icon' => $data['icon'] ?? null,
            'priority' => $data['priority'] ?? 'normal',
        ]);
    }

    /**
     * Create enrollment notification
     */
    public static function enrollmentConfirmation(User $student, $course): Notification
    {
        return self::create([
            'type' => 'enrollment',
            'user_id' => $student->id,
            'title' => 'Enrollment Confirmed!',
            'message' => "You have successfully enrolled in '{$course->title}'. Start learning now!",
            'data' => [
                'course_id' => $course->id,
                'course_title' => $course->title,
            ],
            'action_url' => route('student.courses.show', $course->id),
            'priority' => 'high',
        ]);
    }

    /**
     * Create payment confirmation notification
     */
    public static function paymentConfirmation(User $student, $payment, $course): Notification
    {
        return self::create([
            'type' => 'payment',
            'user_id' => $student->id,
            'title' => 'Payment Successful',
            'message' => "Your payment of ₹{$payment->amount} for '{$course->title}' has been processed successfully.",
            'data' => [
                'payment_id' => $payment->id,
                'course_id' => $course->id,
                'amount' => $payment->amount,
                'transaction_id' => $payment->transaction_id,
            ],
            'action_url' => route('payments.receipt', $payment->id),
            'priority' => 'high',
        ]);
    }

    /**
     * Create class reminder notification
     */
    public static function classReminder(User $student, $onlineClass): Notification
    {
        $minutesUntil = now()->diffInMinutes($onlineClass->scheduled_at, false);
        $timeText = $minutesUntil > 60 ? 
            'in ' . round($minutesUntil / 60) . ' hour(s)' : 
            'in ' . $minutesUntil . ' minute(s)';

        return self::create([
            'type' => 'class_reminder',
            'user_id' => $student->id,
            'title' => 'Class Starting Soon',
            'message' => "'{$onlineClass->title}' starts {$timeText}. Don't miss it!",
            'data' => [
                'class_id' => $onlineClass->id,
                'course_id' => $onlineClass->course_id,
                'scheduled_at' => $onlineClass->scheduled_at->toISOString(),
            ],
            'action_url' => route('online-classes.show', $onlineClass->id),
            'priority' => 'high',
        ]);
    }

    /**
     * Create certificate notification
     */
    public static function certificateAvailable(User $student, $certificate): Notification
    {
        return self::create([
            'type' => 'certificate',
            'user_id' => $student->id,
            'title' => 'Certificate Ready!',
            'message' => "Congratulations! Your certificate for '{$certificate->course->title}' is now available for download.",
            'data' => [
                'certificate_id' => $certificate->id,
                'course_id' => $certificate->course_id,
                'course_title' => $certificate->course->title,
            ],
            'action_url' => route('student.certificates'),
            'priority' => 'high',
        ]);
    }

    /**
     * Create course update notification
     */
    public static function courseUpdate(User $student, $course, string $updateMessage): Notification
    {
        return self::create([
            'type' => 'course_update',
            'user_id' => $student->id,
            'title' => 'Course Updated',
            'message' => "'{$course->title}' has been updated: {$updateMessage}",
            'data' => [
                'course_id' => $course->id,
                'course_title' => $course->title,
                'update_message' => $updateMessage,
            ],
            'action_url' => route('student.courses.show', $course->id),
            'priority' => 'normal',
        ]);
    }

    /**
     * Create new student notification for teachers
     */
    public static function newStudentEnrolled(User $teacher, $student, $course): Notification
    {
        return self::create([
            'type' => 'enrollment',
            'user_id' => $teacher->id,
            'title' => 'New Student Enrolled',
            'message' => "{$student->name} has enrolled in your course '{$course->title}'.",
            'data' => [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'course_id' => $course->id,
                'course_title' => $course->title,
            ],
            'action_url' => route('teacher.students'),
            'priority' => 'normal',
        ]);
    }

    /**
     * Create system notification
     */
    public static function systemNotification(User $user, string $title, string $message, array $data = []): Notification
    {
        return self::create([
            'type' => 'system',
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'priority' => 'normal',
        ]);
    }

    /**
     * Bulk create notifications for multiple users
     */
    public static function bulkCreate(Collection $users, array $notificationData): Collection
    {
        $notifications = collect();

        foreach ($users as $user) {
            $data = array_merge($notificationData, ['user_id' => $user->id]);
            $notifications->push(self::create($data));
        }

        return $notifications;
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead(int $notificationId, int $userId): bool
    {
        $notification = Notification::where('id', $notificationId)
                                  ->where('user_id', $userId)
                                  ->first();

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for a user
     */
    public static function markAllAsRead(int $userId): int
    {
        return Notification::where('user_id', $userId)
                          ->where('is_read', false)
                          ->update([
                              'is_read' => true,
                              'read_at' => now(),
                          ]);
    }

    /**
     * Get unread count for a user
     */
    public static function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
                          ->where('is_read', false)
                          ->count();
    }

    /**
     * Get recent notifications for a user
     */
    public static function getRecent(int $userId, int $limit = 10): Collection
    {
        return Notification::where('user_id', $userId)
                          ->orderBy('created_at', 'desc')
                          ->limit($limit)
                          ->get();
    }

    /**
     * Clean old notifications (older than specified days)
     */
    public static function cleanOldNotifications(int $days = 90): int
    {
        return Notification::where('created_at', '<', now()->subDays($days))
                          ->delete();
    }
}