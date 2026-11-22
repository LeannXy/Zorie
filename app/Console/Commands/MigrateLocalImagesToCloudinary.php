<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\CategoryBanner;
use App\Models\CustomerAccount;
use App\Models\ProductImage;
use App\Models\User;
use App\Services\CloudinaryImageStorage;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateLocalImagesToCloudinary extends Command
{
    protected $signature = 'cloudinary:migrate-local-images {--dry-run}';

    protected $description = 'Migrate existing local image uploads to Cloudinary';

    public function handle(CloudinaryImageStorage $imageStorage): int
    {
        if (! $this->option('dry-run') && config('services.cloudinary.driver') !== 'cloudinary') {
            $this->error('Set IMAGE_STORAGE_DRIVER=cloudinary before running this migration.');

            return self::FAILURE;
        }

        $migrated = 0;
        $skipped = 0;

        $targets = [
            [ProductImage::class, 'image', 'products'],
            [Category::class, 'image', 'categories'],
            [CategoryBanner::class, 'image', 'category-banners'],
            [User::class, 'profile_photo', 'profile-admin'],
            [CustomerAccount::class, 'profile_photo', 'profiles'],
        ];

        foreach ($targets as [$modelClass, $attribute, $directory]) {
            $modelClass::query()
                ->whereNotNull($attribute)
                ->chunkById(100, function ($models) use (
                    $imageStorage,
                    $attribute,
                    $directory,
                    &$migrated,
                    &$skipped,
                ): void {
                    foreach ($models as $model) {
                        $reference = $model->getAttribute($attribute);

                        if (
                            ! is_string($reference)
                            || Str::startsWith($reference, ['http://', 'https://', 'cloudinary:'])
                        ) {
                            $skipped++;

                            continue;
                        }

                        $disk = Storage::disk('public');

                        if (! $disk->exists($reference)) {
                            $this->warn(
                                'Missing local file for '.$model::class.' #'.$model->getKey().': '.$reference
                            );
                            $skipped++;

                            continue;
                        }

                        if ($this->option('dry-run')) {
                            $this->line(
                                'Would migrate '.$model::class.' #'.$model->getKey().': '.$reference
                            );
                            $migrated++;

                            continue;
                        }

                        $path = $disk->path($reference);
                        $file = new UploadedFile(
                            $path,
                            basename($path),
                            mime_content_type($path) ?: null,
                            UPLOAD_ERR_OK,
                            true,
                        );

                        $model->setAttribute(
                            $attribute,
                            $imageStorage->store($file, $directory),
                        );
                        $model->save();
                        $migrated++;
                    }
                });
        }

        $this->info(($this->option('dry-run') ? 'Ready to migrate ' : 'Migrated ').$migrated.' image(s).');
        if ($skipped > 0) {
            $this->warn("Skipped {$skipped} image(s).");
        }

        return self::SUCCESS;
    }
}
