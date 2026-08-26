<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    /**
     * Optimize and convert an uploaded image to WebP format in multiple sizes.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return array
     */
    public static function process(UploadedFile $file, string $folder = 'uploads'): array
    {
        $hash = Str::random(40);
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slugName = Str::slug($originalName);
        $filename = "{$slugName}-{$hash}";

        $tempPath = $file->getRealPath();

        // 1. Load the image based on its type
        $image = null;
        $info = getimagesize($tempPath);
        $mime = $info['mime'] ?? '';

        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            $image = imagecreatefromjpeg($tempPath);
        } elseif ($mime === 'image/png') {
            $image = imagecreatefrompng($tempPath);
            // Preserve PNG transparency if converting or keeping
            imagealphablending($image, true);
            imagesavealpha($image, true);
        } elseif ($mime === 'image/webp') {
            $image = imagecreatefromwebp($tempPath);
        }

        if (!$image) {
            // Fallback: Copy file as-is if GD fails to parse
            $path = $file->storeAs($folder, "{$filename}." . $file->getClientOriginalExtension(), 'public');
            return [
                'original' => Storage::url($path),
                'srcset' => Storage::url($path),
            ];
        }

        $width = imagesx($image);
        $height = imagesy($image);

        // Breakpoints to generate
        $sizes = [
            'thumb' => 300,
            'medium' => 800,
            'large' => 1200,
        ];

        $paths = [];
        $srcsetStrings = [];

        // Save original size in webp format
        $originalWebpName = "{$filename}.webp";
        $originalPath = "{$folder}/{$originalWebpName}";
        
        ob_start();
        imagewebp($image, null, 85); // 85% quality
        $webpData = ob_get_clean();
        Storage::disk('public')->put($originalPath, $webpData);
        $paths['original'] = Storage::url($originalPath);

        // Generate resized versions
        foreach ($sizes as $name => $targetWidth) {
            if ($width <= $targetWidth) {
                // If original is smaller, skip resizing and use original URL
                $paths[$name] = Storage::url($originalPath);
                continue;
            }

            // Calculate height preserving aspect ratio
            $targetHeight = (int) (($height / $width) * $targetWidth);

            // Create canvas
            $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
            
            // Preserve transparency for canvas
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);

            // Resize
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

            // Output webp to memory buffer
            ob_start();
            imagewebp($canvas, null, 80); // 80% quality for resized variants
            $resizedData = ob_get_clean();

            $resizedFilename = "{$filename}-{$targetWidth}.webp";
            $resizedPath = "{$folder}/{$resizedFilename}";
            Storage::disk('public')->put($resizedPath, $resizedData);

            $url = Storage::url($resizedPath);
            $paths[$name] = $url;
            $srcsetStrings[] = "{$url} {$targetWidth}w";

            imagedestroy($canvas);
        }

        // Clean up original canvas
        imagedestroy($image);

        // Add original to srcset too
        $srcsetStrings[] = Storage::url($originalPath) . " {$width}w";

        $paths['srcset'] = implode(', ', $srcsetStrings);

        return $paths;
    }
}
