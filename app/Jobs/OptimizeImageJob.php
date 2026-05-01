<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class OptimizeImageJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $disk,
        public string $path,
    ) {}

    public function handle(): void
    {
        if (!extension_loaded('gd')) {
            return;
        }

        $storage = Storage::disk($this->disk);
        if (!$storage->exists($this->path)) {
            return;
        }

        $absolutePath = $storage->path($this->path);
        if (!is_file($absolutePath)) {
            return;
        }

        $binary = @file_get_contents($absolutePath);
        if ($binary === false) {
            return;
        }

        $source = @imagecreatefromstring($binary);
        if (!$source) {
            return;
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        if ($sourceWidth < 1 || $sourceHeight < 1) {
            imagedestroy($source);
            return;
        }

        $optimized = $this->resizeToMaxWidth($source, $sourceWidth, $sourceHeight, 1920);
        $this->writeByOriginalType($optimized, $absolutePath);

        $thumbnail = $this->createCoverThumbnail($optimized, 480, 320);
        $thumbRelativePath = $this->thumbnailPath($this->path);
        $thumbAbsolutePath = $storage->path($thumbRelativePath);
        $thumbDir = dirname($thumbAbsolutePath);
        if (!is_dir($thumbDir)) {
            @mkdir($thumbDir, 0755, true);
        }
        imagewebp($thumbnail, $thumbAbsolutePath, 78);

        imagedestroy($thumbnail);
        if ($optimized !== $source) {
            imagedestroy($optimized);
        }
        imagedestroy($source);
    }

    private function resizeToMaxWidth(\GdImage $source, int $width, int $height, int $maxWidth): \GdImage
    {
        if ($width <= $maxWidth) {
            return $source;
        }

        $targetWidth = $maxWidth;
        $targetHeight = (int) round(($height / $width) * $targetWidth);
        $resized = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefilledrectangle($resized, 0, 0, $targetWidth, $targetHeight, $transparent);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        return $resized;
    }

    private function createCoverThumbnail(\GdImage $source, int $targetWidth, int $targetHeight): \GdImage
    {
        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);
        $sourceRatio = $sourceWidth / $sourceHeight;
        $targetRatio = $targetWidth / $targetHeight;

        if ($sourceRatio > $targetRatio) {
            $cropHeight = $sourceHeight;
            $cropWidth = (int) round($cropHeight * $targetRatio);
            $cropX = (int) round(($sourceWidth - $cropWidth) / 2);
            $cropY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) round($cropWidth / $targetRatio);
            $cropX = 0;
            $cropY = (int) round(($sourceHeight - $cropHeight) / 2);
        }

        $thumb = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($thumb, true);
        imagesavealpha($thumb, true);
        imagecopyresampled(
            $thumb,
            $source,
            0,
            0,
            $cropX,
            $cropY,
            $targetWidth,
            $targetHeight,
            $cropWidth,
            $cropHeight
        );

        return $thumb;
    }

    private function writeByOriginalType(\GdImage $image, string $path): void
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        match ($extension) {
            'jpg', 'jpeg' => imagejpeg($image, $path, 82),
            'png' => imagepng($image, $path, 6),
            'webp' => imagewebp($image, $path, 80),
            'gif' => imagegif($image, $path),
            default => imagewebp($image, $path . '.webp', 80),
        };
    }

    private function thumbnailPath(string $path): string
    {
        $dirname = pathinfo($path, PATHINFO_DIRNAME);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $dirPrefix = $dirname === '.' ? '' : ($dirname . '/');

        return $dirPrefix . $filename . '_thumb.webp';
    }
}
