<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/settings/profile',
        [SettingsController::class, 'index']
    )->name('settings.profile');

    Route::post(
        '/settings/update',
        [SettingsController::class, 'update']
    )->name('settings.update');

    Route::get(
        '/settings/security',
        [SettingsController::class, 'security']
    )->name('settings.security');

    Route::post(
        '/settings/password',
        [SettingsController::class, 'updatePassword']
    )->name('settings.password');

    Route::get(
        '/settings/appearance',
        [SettingsController::class, 'appearance']
    )->name(
        'settings.appearance'
    );

    Route::post(
        '/settings/appearance',
        [SettingsController::class, 'updateAppearance']
    )->name(
        'settings.appearance.update'
    );



    Route::get(
        '/settings/notifications',
        [SettingsController::class, 'notifications']
    )->name(
        'settings.notifications'
    );

    Route::post(
        '/settings/notifications',
        [SettingsController::class, 'updateNotifications']
    )->name(
        'settings.notifications.update'
    );

    Route::delete(
        '/notification/{notification}',
        [SettingsController::class, 'deleteNotification']
    )->name(
        'notification.delete'
    );





    Route::get(
        '/settings/system',
        [SettingsController::class, 'system']
    )->name('settings.system');

    Route::post(
        '/settings/system',
        [SettingsController::class, 'updateSystem']
    )->name('settings.system.update');




    Route::get(
        '/settings/activity',
        [SettingsController::class, 'activity']
    )->name('settings.activity');


    Route::get(
        '/settings/backup',
        [SettingsController::class, 'backup']
    )->name('settings.backup');
    Route::post(
        '/settings/backup/create',
        [SettingsController::class, 'createBackup']
    )->name('settings.backup.create');
    Route::post(
        '/settings/backup/create',
        [SettingsController::class, 'createBackup']
    )->name('settings.backup.create');
    Route::get(
        '/settings/backup/download',
        [SettingsController::class, 'downloadBackup']
    )->name('settings.backup.download');
    Route::get(
        '/settings/backup/download',
        [SettingsController::class, 'downloadBackup']
    )->name('settings.backup.download');
    Route::post(
        '/settings/backup/{file}/restore',
        [SettingsController::class, 'restoreBackup']
    )->name('settings.backup.restore');
});
