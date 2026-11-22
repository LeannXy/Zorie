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

// Arahkan storage Laravel ke /tmp agar tidak error read-only di Vercel
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath . '/framework/views', 0755, true);
    mkdir($storagePath . '/framework/cache/data', 0755, true);
    mkdir($storagePath . '/framework/sessions', 0755, true);
    mkdir($storagePath . '/logs', 0755, true);
}
$app->useStoragePath($storagePath);

return $app;