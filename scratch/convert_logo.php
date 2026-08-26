<?php

function makeLogoTransparent($sourcePath, $destPath) {
    $img = @imagecreatefromjpeg($sourcePath);
    if (!$img) {
        $img = @imagecreatefrompng($sourcePath);
    }

    if (!$img) {
        echo "Failed to load image from {$sourcePath}\n";
        return false;
    }

    $width = imagesx($img);
    $height = imagesy($img);

    $newImg = imagecreatetruecolor($width, $height);
    imagealphablending($newImg, false);
    imagesavealpha($newImg, true);

    $transparentColor = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
    imagefill($newImg, 0, 0, $transparentColor);

    // Loop through pixels and key out the black background
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // If color is not close to black, copy it
            if ($r > 20 || $g > 20 || $b > 20) {
                $color = imagecolorallocatealpha($newImg, $r, $g, $b, 0);
                imagesetpixel($newImg, $x, $y, $color);
            }
        }
    }

    imagepng($newImg, $destPath);
    imagedestroy($img);
    imagedestroy($newImg);
    echo "Converted {$sourcePath} to transparent PNG at {$destPath}\n";
    return true;
}

// Convert both white text and purple text logos
makeLogoTransparent('/Users/syamsul/Documents/Coding/Project/demo-taqwamovement/public/images/logo-dark-bg.png', '/Users/syamsul/Documents/Coding/Project/demo-taqwamovement/public/images/logo-dark-bg.png');
makeLogoTransparent('/Users/syamsul/Documents/Coding/Project/demo-taqwamovement/public/images/logo-white-bg.png', '/Users/syamsul/Documents/Coding/Project/demo-taqwamovement/public/images/logo-white-bg.png');
