<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;

class ConvertImagesToBase64 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses:convert-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert existing course images from file paths to base64 format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting course image conversion...');
        
        $courses = Course::whereNotNull('thumbnail')
            ->where('thumbnail', 'not like', 'data:image/%')
            ->get();

        $converted = 0;
        $failed = 0;

        foreach ($courses as $course) {
            try {
                $path = $course->thumbnail;
                
                // Remove 'storage/' prefix if exists
                if (strpos($path, 'storage/') === 0) {
                    $path = substr($path, 8);
                }

                // Try storage path first
                $fullPath = storage_path('app/public/' . $path);
                if (!file_exists($fullPath)) {
                    // Try public storage path
                    $fullPath = public_path('storage/' . $path);
                }

                if (file_exists($fullPath)) {
                    $originalSize = filesize($fullPath);
                    
                    // If image is larger than 200KB, skip it for now
                    if ($originalSize > 200 * 1024) {
                        $this->warn("Skipping Course ID {$course->id}: Image too large (" . number_format($originalSize) . " bytes). Please manually replace with smaller image.");
                        
                        // Set a placeholder for now
                        $course->update(['thumbnail' => null]);
                        $failed++;
                        continue;
                    }
                    
                    $imageData = file_get_contents($fullPath);
                    $mimeType = mime_content_type($fullPath);
                    $base64 = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
                    
                    $course->update(['thumbnail' => $base64]);
                    $converted++;
                    $this->info("Converted Course ID {$course->id}: {$course->title}");
                } else {
                    $this->warn("File not found for Course ID {$course->id}: {$course->thumbnail}");
                    $failed++;
                }
            } catch (\Exception $e) {
                $this->error("Error converting Course ID {$course->id}: " . $e->getMessage());
                $failed++;
            }
        }

        $this->info("Conversion complete!");
        $this->info("Converted: {$converted} images");
        $this->info("Failed: {$failed} images");

        return 0;
    }

    private function resizeImage($imagePath, $maxSize)
    {
        $imageInfo = getimagesize($imagePath);
        if (!$imageInfo) {
            return false;
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo[2];

        // Create image resource based on type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($imagePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($imagePath);
                break;
            default:
                return false;
        }

        if (!$source) {
            return false;
        }

        // Calculate new dimensions (maintain aspect ratio)
        $quality = 85;
        $scale = 0.9;
        
        do {
            $newWidth = (int)($width * $scale);
            $newHeight = (int)($height * $scale);
            
            // Create new image
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Handle transparency for PNG
            if ($type == IMAGETYPE_PNG) {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            }
            
            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            
            // Capture output
            ob_start();
            switch ($type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($resized, null, $quality);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($resized, null, (int)(9 * (1 - $quality/100)));
                    break;
                case IMAGETYPE_GIF:
                    imagegif($resized, null);
                    break;
            }
            $imageData = ob_get_clean();
            
            imagedestroy($resized);
            
            // Reduce quality/scale if still too large
            if (strlen($imageData) > $maxSize) {
                $quality -= 10;
                $scale -= 0.05;
            }
            
        } while (strlen($imageData) > $maxSize && $quality > 10 && $scale > 0.1);
        
        imagedestroy($source);
        
        return strlen($imageData) <= $maxSize ? $imageData : false;
    }
}
