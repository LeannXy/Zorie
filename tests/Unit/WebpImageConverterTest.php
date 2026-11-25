<?php

use App\Services\WebpImageConverter;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

uses(TestCase::class);

it('converts raster images to WebP without changing their dimensions', function () {
    $convertedPath = app(WebpImageConverter::class)->convert(
        UploadedFile::fake()->image('shoe.jpg', 320, 180),
    );

    try {
        $image = getimagesize($convertedPath);

        expect($image['mime'])->toBe('image/webp')
            ->and($image[0])->toBe(320)
            ->and($image[1])->toBe(180);
    } finally {
        if (is_string($convertedPath) && is_file($convertedPath)) {
            unlink($convertedPath);
        }
    }
});

it('keeps WebP, GIF, and SVG source files in their original format', function () {
    $converter = app(WebpImageConverter::class);

    expect($converter->convert(UploadedFile::fake()->create('existing.webp', 10, 'image/webp')))
        ->toBeNull()
        ->and($converter->convert(UploadedFile::fake()->create('animated.gif', 10, 'image/gif')))
        ->toBeNull()
        ->and($converter->convert(UploadedFile::fake()->create('vector.svg', 10, 'image/svg+xml')))
        ->toBeNull();
});
