<?php
/**
 * Script to create a default course thumbnail placeholder image
 * Run: php tools/create_default_thumbnail.php
 */

$width = 640;
$height = 360;
$img = imagecreatetruecolor($width, $height);

// Background color (a nice gradient-like blue)
$bgColor = imagecolorallocate($img, 59, 130, 246);
$textColor = imagecolorallocate($img, 255, 255, 255);
$accentColor = imagecolorallocate($img, 96, 165, 250);

// Fill background
imagefill($img, 0, 0, $bgColor);

// Add some visual interest with a rectangle
imagefilledrectangle($img, 0, $height - 60, $width, $height, $accentColor);

// Add text
$text = 'Course Image';
$fontPath = 'C:/Windows/Fonts/arial.ttf';
if (file_exists($fontPath)) {
    $fontSize = 32;
    $bbox = imagettfbbox($fontSize, 0, $fontPath, $text);
    $textWidth = $bbox[2] - $bbox[0];
    $textHeight = $bbox[1] - $bbox[7];
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    imagettftext($img, $fontSize, 0, $x, $y + $textHeight, $textColor, $fontPath, $text);
} else {
    $x = ($width - strlen($text) * 9) / 2;
    $y = $height / 2;
    imagestring($img, 5, $x, $y, $text, $textColor);
}

// Ensure public/img directory exists
$outputPath = __DIR__ . '/../public/img/default-course-thumbnail.png';
if (!is_dir(dirname($outputPath))) {
    mkdir(dirname($outputPath), 0755, true);
}

// Save the image
imagepng($img, $outputPath);
imagedestroy($img);

echo "Default thumbnail created successfully at: $outputPath\n";
