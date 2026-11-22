<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class CloudinaryImageStorage
{
    private const REFERENCE_PREFIX = 'cloudinary:';

    public function store(UploadedFile $image, string $directory): string
    {
        $driver = config('services.cloudinary.driver');

        if ($driver === 'local') {
            $path = $image->store($directory, 'public');

            if (! is_string($path)) {
                throw new RuntimeException('The image could not be saved to local storage.');
            }

            return $path;
        }

        if ($driver !== 'cloudinary') {
            throw new InvalidArgumentException("Unsupported image storage driver [{$driver}].");
        }

        $publicId = trim(config('services.cloudinary.folder', 'zorie'), '/')
            .'/'.trim($directory, '/')
            .'/'.Str::uuid();

        $result = $this->uploadApi()->upload($image->getRealPath(), [
            'public_id' => $publicId,
            'overwrite' => false,
            'resource_type' => 'image',
        ]);

        $uploadedPublicId = $result['public_id'] ?? null;

        if (! is_string($uploadedPublicId) || $uploadedPublicId === '') {
            throw new RuntimeException('Cloudinary did not return an image public ID.');
        }

        return self::REFERENCE_PREFIX.$uploadedPublicId;
    }

    public function url(?string $reference): ?string
    {
        if ($reference === null || $reference === '') {
            return null;
        }

        if (Str::startsWith($reference, ['http://', 'https://'])) {
            return $reference;
        }

        if (Str::startsWith($reference, self::REFERENCE_PREFIX)) {
            $cloudName = config('services.cloudinary.cloud_name');

            if (! is_string($cloudName) || $cloudName === '') {
                throw new RuntimeException('CLOUDINARY_CLOUD_NAME must be configured to display Cloudinary images.');
            }

            $publicId = Str::after($reference, self::REFERENCE_PREFIX);
            $encodedPublicId = implode('/', array_map('rawurlencode', explode('/', $publicId)));

            return "https://res.cloudinary.com/{$cloudName}/image/upload/f_auto,q_auto/{$encodedPublicId}";
        }

        return Storage::disk('public')->url($reference);
    }

    public function delete(?string $reference): bool
    {
        if ($reference === null || $reference === '') {
            return false;
        }

        if (Str::startsWith($reference, self::REFERENCE_PREFIX)) {
            $result = $this->uploadApi()->destroy(
                Str::after($reference, self::REFERENCE_PREFIX),
                ['invalidate' => true, 'resource_type' => 'image'],
            );
            $status = $result['result'] ?? null;

            if (! in_array($status, ['ok', 'not found'], true)) {
                throw new RuntimeException('Cloudinary did not confirm image deletion.');
            }

            return $status === 'ok';
        }

        if (Str::startsWith($reference, ['http://', 'https://'])) {
            return false;
        }

        return Storage::disk('public')->delete($reference);
    }

    private function uploadApi(): UploadApi
    {
        $cloudName = config('services.cloudinary.cloud_name');
        $apiKey = config('services.cloudinary.api_key');
        $apiSecret = config('services.cloudinary.api_secret');

        if (! is_string($cloudName) || $cloudName === ''
            || ! is_string($apiKey) || $apiKey === ''
            || ! is_string($apiSecret) || $apiSecret === '') {
            throw new RuntimeException(
                'Cloudinary image storage is enabled, but CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY, '
                .'and CLOUDINARY_API_SECRET must all be configured.'
            );
        }

        return new UploadApi([
            'cloud' => [
                'cloud_name' => $cloudName,
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
            ],
            'url' => ['secure' => true],
        ]);
    }
}
