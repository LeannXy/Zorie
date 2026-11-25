<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class WebpImageConverter
{
    private const QUALITY = 85;

    public function convert(UploadedFile $image, string $field = 'image'): ?string
    {
        $mimeType = $image->getMimeType();
        $extension = strtolower($image->getClientOriginalExtension());

        if (
            in_array($mimeType, ['image/webp', 'image/gif', 'image/svg+xml'], true)
            || in_array($extension, ['webp', 'gif', 'svg'], true)
        ) {
            return null;
        }

        if (! function_exists('imagecreatefromstring') || ! function_exists('imagewebp')) {
            throw new RuntimeException('GD with WebP support is required to convert uploaded images.');
        }

        $contents = file_get_contents($image->getRealPath());

        if ($contents === false) {
            throw new RuntimeException('The uploaded image could not be read for WebP conversion.');
        }

        $source = @imagecreatefromstring($contents);

        if ($source === false) {
            throw ValidationException::withMessages([
                $field => 'Format gambar ini tidak didukung untuk konversi WebP. Gunakan gambar raster yang didukung, GIF, atau SVG.',
            ]);
        }

        if (! imageistruecolor($source)) {
            imagepalettetotruecolor($source);
        }

        imagealphablending($source, false);
        imagesavealpha($source, true);

        $temporaryPath = tempnam(sys_get_temp_dir(), 'zorie-webp-');

        if ($temporaryPath === false) {
            imagedestroy($source);

            throw new RuntimeException('A temporary file could not be created for WebP conversion.');
        }

        $webpPath = $temporaryPath.'.webp';

        if (! rename($temporaryPath, $webpPath)) {
            imagedestroy($source);
            unlink($temporaryPath);

            throw new RuntimeException('A temporary WebP file could not be prepared.');
        }

        try {
            if (! imagewebp($source, $webpPath, self::QUALITY)) {
                unlink($webpPath);

                throw new RuntimeException('The uploaded image could not be encoded as WebP.');
            }
        } finally {
            imagedestroy($source);
        }

        return $webpPath;
    }
}
