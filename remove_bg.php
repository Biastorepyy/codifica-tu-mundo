<?php
$src = 'assets/img/escudo_crece.png';
$dest = 'assets/img/escudo_crece_trans.png';

if (!file_exists($src)) {
    die("Source file not found.");
}

$img = imagecreatefrompng($src);
if (!$img) {
    die("Could not read image.");
}

$width = imagesx($img);
$height = imagesy($img);

$new_img = imagecreatetruecolor($width, $height);
imagealphablending($new_img, false);
imagesavealpha($new_img, true);

$transparent = imagecolorallocatealpha($new_img, 0, 0, 0, 127);
imagefill($new_img, 0, 0, $transparent);

for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $rgb = imagecolorat($img, $x, $y);
        $colors = imagecolorsforindex($img, $rgb);
        
        // Define a threshold for "white"
        if ($colors['red'] > 235 && $colors['green'] > 235 && $colors['blue'] > 235) {
            // Transparent
            imagesetpixel($new_img, $x, $y, $transparent);
        } else {
            // Original color (preserve alpha if any)
            $color = imagecolorallocatealpha($new_img, $colors['red'], $colors['green'], $colors['blue'], $colors['alpha']);
            imagesetpixel($new_img, $x, $y, $color);
        }
    }
}

imagepng($new_img, $dest);
imagedestroy($img);
imagedestroy($new_img);

echo "Success";
?>
