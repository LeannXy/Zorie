<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadBrandLogos extends Command
{
    protected $signature   = 'brands:download';
    protected $description = 'Download semua logo brand ke public/images/brands/';

    protected array $logos = [
        'adidas'      => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg',
        'nike'        => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg',
        'new-balance' => 'https://upload.wikimedia.org/wikipedia/commons/e/ea/New_Balance_logo.svg',
        'puma'        => 'https://upload.wikimedia.org/wikipedia/commons/4/49/Puma-logo-%28text%29.svg',
        'reebok'      => 'https://upload.wikimedia.org/wikipedia/commons/0/0f/Reebok_2019_logo.svg',
        'asics'       => 'https://upload.wikimedia.org/wikipedia/commons/b/b1/Asics_Logo.svg',
        'converse'    => 'https://upload.wikimedia.org/wikipedia/commons/3/30/Converse_logo.svg',
    ];

    public function handle(): void
    {
        $dir = public_path('images/brands');

        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
            $this->info("Folder dibuat: $dir");
        }

        foreach ($this->logos as $name => $url) {
            $dest = "$dir/{$name}.svg";

            if (file_exists($dest)) {
                $this->line("  <fg=yellow>SKIP</>  {$name}.svg (sudah ada)");
                continue;
            }

            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; ZorieBot/1.0)',
                ])->timeout(10)->get($url);

                if ($response->successful()) {
                    file_put_contents($dest, $response->body());
                    $this->line("  <fg=green>OK</>    {$name}.svg");
                } else {
                    $this->line("  <fg=red>FAIL</>  {$name}.svg — HTTP {$response->status()}");
                }
            } catch (\Exception $e) {
                $this->line("  <fg=red>ERROR</> {$name}.svg — {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info('Selesai! Logo tersimpan di public/images/brands/');
    }
}