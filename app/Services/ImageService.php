<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Convert uploaded image (JPG, PNG, WEBP, GIF) to compressed WEBP format
     * with automatic resizing (downscaling if larger than max dimensions) and quality compression.
     */
    public static function storeAsWebp(
        UploadedFile $file,
        string $directory = 'uploads',
        int $maxWidth = 1920,
        int $maxHeight = 1920,
        int $quality = 80
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getMimeType();
        $realPath = $file->getRealPath();

        $image = null;

        if (str_contains($mime, 'jpeg') || in_array($extension, ['jpg', 'jpeg'])) {
            $image = @imagecreatefromjpeg($realPath);
        } elseif (str_contains($mime, 'png') || $extension === 'png') {
            $image = @imagecreatefrompng($realPath);
        } elseif (str_contains($mime, 'webp') || $extension === 'webp') {
            $image = @imagecreatefromwebp($realPath);
        } elseif (str_contains($mime, 'gif') || $extension === 'gif') {
            $image = @imagecreatefromgif($realPath);
        }

        if (! $image) {
            return $file->store($directory, 'public');
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        $width = $origWidth;
        $height = $origHeight;

        if ($width > $maxWidth || $height > $maxHeight) {
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $width = (int) max(1, round($width * $ratio));
            $height = (int) max(1, round($height * $ratio));
        }

        $canvas = imagecreatetruecolor($width, $height);

        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $width, $height, $transparent);

        imagecopyresampled($canvas, $image, 0, 0, 0, 0, $width, $height, $origWidth, $origHeight);

        $filename = Str::random(40).'.webp';
        $relativePath = trim($directory, '/').'/'.$filename;
        $fullPath = storage_path('app/public/'.$relativePath);

        $dirPath = dirname($fullPath);
        if (! is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        imagewebp($canvas, $fullPath, $quality);

        imagedestroy($image);
        imagedestroy($canvas);

        return $relativePath;
    }
}
