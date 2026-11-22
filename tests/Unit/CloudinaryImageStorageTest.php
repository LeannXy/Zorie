<?php

use App\Services\CloudinaryImageStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class);

it('stores locally and resolves local image URLs when local storage is selected', function () {
    config()->set('services.cloudinary.driver', 'local');
    Storage::fake('public');

    $path = app(CloudinaryImageStorage::class)->store(
        UploadedFile::fake()->create('shoe.jpg', 10, 'image/jpeg'),
        'products',
    );

    expect(Storage::disk('public')->exists($path))->toBeTrue()
        ->and(media_url($path))->toBe(Storage::disk('public')->url($path));
});

it('resolves Cloudinary references to secure delivery URLs', function () {
    config()->set('services.cloudinary.cloud_name', 'test-cloud');

    expect(media_url('cloudinary:zorie/products/test-image'))
        ->toBe('https://res.cloudinary.com/test-cloud/image/upload/f_auto,q_auto/zorie/products/test-image');
});

it('preserves existing remote image URLs', function () {
    $url = 'https://example.com/avatar.jpg';

    expect(media_url($url))->toBe($url);
});

it('does not silently store locally when Cloudinary is selected without credentials', function () {
    config()->set('services.cloudinary.driver', 'cloudinary');
    config()->set('services.cloudinary.cloud_name', null);
    config()->set('services.cloudinary.api_key', null);
    config()->set('services.cloudinary.api_secret', null);

    expect(fn () => app(CloudinaryImageStorage::class)->store(
        UploadedFile::fake()->create('shoe.jpg', 10, 'image/jpeg'),
        'products',
    ))->toThrow(RuntimeException::class, 'CLOUDINARY_CLOUD_NAME');
});
