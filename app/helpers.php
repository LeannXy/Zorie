<?php

use App\Services\CloudinaryImageStorage;

if (! function_exists('media_url')) {
    function media_url(?string $reference): ?string
    {
        return app(CloudinaryImageStorage::class)->url($reference);
    }
}
