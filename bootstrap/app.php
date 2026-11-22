<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(
    basePath: dirname(__DIR__)
)
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    pages: __DIR__.'/../resources/views/livewire',
)
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'CheckCustomerSession' => \App\Http\Middleware\CheckCustomerSession::class,
    ]);
    $middleware->trustProxies(at: '*');
})
->withExceptions(function (Exceptions $exceptions): void {
    //
})
->create();

// Vercel's application filesystem is read-only except for /tmp.
if (getenv('VERCEL') === '1') {
    $storagePath = '/tmp/storage';

    foreach ([
        $storagePath.'/framework/views',
        $storagePath.'/framework/cache/data',
        $storagePath.'/framework/sessions',
        $storagePath.'/logs',
    ] as $directory) {
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    $app->useStoragePath($storagePath);
}

return $app;