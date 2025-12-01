<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Enrollment;
use App\Models\User;
use App\Services\NotificationService;

class CheckExpiredEnrollments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enrollments:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and mark expired enrollments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired enrollments...');
        
        // Find enrollments that have expired but are not marked as expired
        $expiredEnrollments = Enrollment::where('is_expired', false)
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        $count = $expiredEnrollments->count();
        
        if ($count > 0) {
            $this->info("Found {$count} expired enrollments. Updating...");
            
            foreach ($expiredEnrollments as $enrollment) {
                // Mark as expired
                $enrollment->update([
                    'is_expired' => true,
                    'status' => 'expired'
                ]);
                
                // Notify student about expiration
                try {
                    NotificationService::courseAccessExpired($enrollment->student, $enrollment->course);
                } catch (\Exception $e) {
                    $this->warn("Failed to send notification for enrollment ID: {$enrollment->id}");
                }
                
                $this->line("- Marked enrollment ID {$enrollment->id} as expired for user {$enrollment->student->name}");
            }
            
            $this->info("Successfully updated {$count} expired enrollments.");
        } else {
            $this->info('No expired enrollments found.');
        }

        // Also show summary of enrollments expiring soon (within 7 days)
        $expiringSoon = Enrollment::where('is_expired', false)
            ->whereNotNull('expires_at')
            ->whereBetween('expires_at', [now(), now()->addDays(7)])
            ->count();

        if ($expiringSoon > 0) {
            $this->warn("Note: {$expiringSoon} enrollments will expire within the next 7 days.");
        }

        return 0;
    }
}
