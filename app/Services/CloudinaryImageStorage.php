<?php

namespace App\Services;

use Cloudinary\Api\ApiUtils;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

        $assetFolder = $this->assetFolder($directory);
        $publicId = $assetFolder.'/'.Str::uuid();

        $result = $this->uploadApi()->upload($image->getRealPath(), [
            'asset_folder' => $assetFolder,
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

    public function signedUpload(string $directory): array
    {
        if (config('services.cloudinary.driver') !== 'cloudinary') {
            throw new RuntimeException('Direct uploads require IMAGE_STORAGE_DRIVER=cloudinary.');
        }

        $cloud = $this->uploadApi()->getCloud();
        $assetFolder = $this->assetFolder($directory);
        $publicId = $assetFolder.'/'.Str::uuid();
        $timestamp = now()->timestamp;
        $parameters = [
            'asset_folder' => $assetFolder,
            'overwrite' => 'false',
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];

        return [
            'cloud_name' => config('services.cloudinary.cloud_name'),
            'api_key' => config('services.cloudinary.api_key'),
            'asset_folder' => $assetFolder,
            'public_id' => $publicId,
            'timestamp' => $timestamp,
            'signature' => ApiUtils::signParameters(
                $parameters,
                $cloud->apiSecret,
                $cloud->signatureAlgorithm,
            ),
            'upload_url' => 'https://api.cloudinary.com/v1_1/'
                .rawurlencode(config('services.cloudinary.cloud_name'))
                .'/image/upload',
        ];
    }

    public function storeRequestImage(Request $request, string $field, string $directory): ?string
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);

            if ($file instanceof UploadedFile) {
                return $this->store($file, $directory);
            }
        }

        $reference = $request->input($field);

        return is_string($reference) && $reference !== ''
            ? $this->acceptDirectReference($reference, $directory, $field)
            : null;
    }

    public function storeRequestImages(Request $request, string $field, string $directory): array
    {
        $stored = [];
        $files = $request->file($field, []);

        foreach (is_array($files) ? $files : [$files] as $file) {
            if ($file instanceof UploadedFile) {
                $stored[] = $this->store($file, $directory);
            }
        }

        $references = $request->input($field, []);
        foreach (is_array($references) ? $references : [$references] as $reference) {
            if (is_string($reference) && $reference !== '') {
                $stored[] = $this->acceptDirectReference($reference, $directory, $field);
            }
        }

        return $stored;
    }

    public function acceptDirectReference(string $reference, string $directory, string $field): string
    {
        if (config('services.cloudinary.driver') !== 'cloudinary') {
            throw ValidationException::withMessages([
                $field => 'Direct image uploads are not enabled.',
            ]);
        }

        $parts = explode('|', $reference);
        $signedReference = $parts[0] ?? '';
        $timestamp = isset($parts[1]) ? filter_var($parts[1], FILTER_VALIDATE_INT) : false;
        $signature = $parts[2] ?? '';
        $publicId = Str::after($signedReference, self::REFERENCE_PREFIX);
        $assetFolder = $this->assetFolder($directory);
        $expectedPrefix = $assetFolder.'/';
        $cloud = $this->uploadApi()->getCloud();
        $expectedSignature = $timestamp === false
            ? ''
            : ApiUtils::signParameters(
                [
                    'asset_folder' => $assetFolder,
                    'overwrite' => 'false',
                    'public_id' => $publicId,
                    'timestamp' => $timestamp,
                ],
                $cloud->apiSecret,
                $cloud->signatureAlgorithm,
            );

        if (
            count($parts) !== 3
            || ! Str::startsWith($signedReference, self::REFERENCE_PREFIX)
            || ! Str::startsWith($publicId, $expectedPrefix)
            || $timestamp === false
            || $timestamp < now()->timestamp - 3600
            || $timestamp > now()->timestamp + 60
            || ! hash_equals($expectedSignature, $signature)
        ) {
            throw ValidationException::withMessages([
                $field => 'The uploaded image reference is invalid.',
            ]);
        }

        return $signedReference;
    }

    private function assetFolder(string $directory): string
    {
        return trim(config('services.cloudinary.folder', 'zorie'), '/')
            .'/'.trim($directory, '/');
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
