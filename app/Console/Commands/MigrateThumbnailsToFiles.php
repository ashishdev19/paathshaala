<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateThumbnailsToFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:migrate-thumbnails 
                            {--dry-run : Show what would be migrated without making changes}
                            {--limit= : Limit the number of courses to process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate base64 encoded thumbnails to file storage for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $limit = $this->option('limit');
        
        $this->info('Starting thumbnail migration...');
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }
        
        // Get courses with base64 thumbnails
        $query = Course::whereNotNull('thumbnail')
            ->where('thumbnail', 'like', 'data:image/%');
        
        if ($limit) {
            $query->limit((int)$limit);
        }
        
        $courses = $query->get();
        
        $this->info("Found {$courses->count()} courses with base64 thumbnails");
        
        if ($courses->isEmpty()) {
            $this->info('No base64 thumbnails to migrate.');
            return 0;
        }
        
        $bar = $this->output->createProgressBar($courses->count());
        $bar->start();
        
        $successCount = 0;
        $failCount = 0;
        
        foreach ($courses as $course) {
            try {
                $thumbnail = $course->thumbnail;
                
                // Extract mime type and data
                if (preg_match('/^data:image\/(\w+);base64,(.+)$/', $thumbnail, $matches)) {
                    $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
                    $base64Data = $matches[2];
                    
                    // Decode the image
                    $imageData = base64_decode($base64Data);
                    
                    if ($imageData === false) {
                        $this->error("\nFailed to decode base64 for course {$course->id}");
                        $failCount++;
                        $bar->advance();
                        continue;
                    }
                    
                    // Generate filename
                    $filename = 'course_' . $course->id . '_migrated_' . time() . '.' . $extension;
                    $path = 'courses/thumbnails/' . $filename;
                    
                    if (!$dryRun) {
                        // Store the file
                        Storage::disk('public')->put($path, $imageData);
                        
                        // Update the course
                        $course->thumbnail = $path;
                        $course->save();
                    }
                    
                    $successCount++;
                } else {
                    $this->warn("\nUnrecognized base64 format for course {$course->id}");
                    $failCount++;
                }
            } catch (\Exception $e) {
                $this->error("\nError processing course {$course->id}: {$e->getMessage()}");
                $failCount++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info("Migration complete!");
        $this->info("Successfully migrated: {$successCount}");
        if ($failCount > 0) {
            $this->warn("Failed: {$failCount}");
        }
        
        if ($dryRun) {
            $this->warn('This was a dry run. Run without --dry-run to apply changes.');
        }
        
        return 0;
    }
}
