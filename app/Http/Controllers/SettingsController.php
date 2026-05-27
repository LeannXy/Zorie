<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\Notification;


class SettingsController extends Controller
{
    public function index()
    {
        return view('pages.settings-profile');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,' . $user->id,

            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

        ]);

        $user->name = $validated['name'];

        $user->email = $validated['email'];


        if ($request->hasFile('profile_photo')) {

            if (
                $user->profile_photo &&
                Storage::disk('public')->exists($user->profile_photo)
            ) {

                Storage::disk('public')->delete(
                    $user->profile_photo
                );
            }

            $user->profile_photo = $request
                ->file('profile_photo')
                ->store(
                    'profile-admin',
                    'public'
                );
        }

        $user->save();
        $this->createNotification(

            'Profile updated',

            'Your profile information was updated',

            'user'

        );
        $this->logActivity(

            'Profile updated',

            'user'

        );


        return back()->with(
            'success',
            'Profile updated successfully'
        );
    }
    public function security()
    {
        return view('pages.settings-security');
    }


    public function updatePassword(
        Request $request
    ) {
        $request->validate([

            'current_password' =>
            'required',

            'password' =>
            'required|min:8|confirmed'

        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {

            return back()
                ->withErrors([

                    'current_password' =>
                    'Current password is incorrect'

                ]);
        }

        $user->password =
            Hash::make(
                $request->password
            );

        $user->save();

        $this->createNotification(

            'Password changed',

            'Your account password was changed',

            'shield'

        );

        $this->logActivity(

            'Password changed',

            'shield'

        );

        return back()
            ->with(
                'success',
                'Password updated successfully'
            );
    }


    public function system()
    {
        $settings = Setting::firstOrCreate(
            ['id' => 1]
        );

        return view(
            'pages.settings-system',
            compact(
                'settings'
            )
        );
    }

    public function updateSystem(
        Request $request
    ) {
        $request->validate([

            'store_name' => 'required',

            'store_email' => 'required|email',

            'store_phone' => 'nullable',

            'currency' => 'required',

            'timezone' => 'required'

        ]);

        Setting::updateOrCreate(

            ['id' => 1],

            [

                'store_name' => $request->store_name,

                'store_email' => $request->store_email,

                'store_phone' => $request->store_phone,

                'currency' => $request->currency,

                'timezone' => $request->timezone,

                'maintenance_mode' =>
                $request->boolean(
                    'maintenance_mode'
                ),

                'auto_backup' =>
                $request->boolean(
                    'auto_backup'
                )

            ]

        );

        $this->createNotification(

            'System updated',

            'System settings updated successfully',

            'settings'

        );

        $this->logActivity(

            'System settings updated',

            'settings'
        );

        return back()->with(

            'success',

            'System updated successfully'

        );
    }

    public function activity()
    {
        $activities = ActivityLog::with(
            'user'
        )
            ->latest()
            ->paginate(10);

        return view(
            'pages.settings-activity',
            compact(
                'activities'
            )
        );
    }

    public function backup()
    {
        $productSize = $this->folderSize(
            storage_path(
                'app/public/products'
            )
        );

        $profileSize = $this->folderSize(
            storage_path(
                'app/public/profile-admin'
            )
        );

        $backupSize = $this->folderSize(
            storage_path(
                'app/private'
            )
        );

        $backups = [];

        $backupFolder = storage_path(
            'app/private'
        );

        if (File::exists($backupFolder)) {
            $backups = File::allFiles(
                $backupFolder
            );
        }

        return view(
            'pages.settings-backup',
            compact(
                'productSize',
                'profileSize',
                'backupSize',
                'backups'
            )
        );
    }




    public function createBackup()
    {
        $filename = 'backup-' . now()->format('Y-m-d-His') . '.sql';

        $path = storage_path(
            'app/private/' . $filename
        );

        $command = sprintf(
            'mysqldump -u%s -p%s %s > "%s"',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $path
        );

        exec($command);

        Cache::put(
            'last_backup',
            now()->format(
                'd M Y H:i'
            )
        );

        $this->createNotification(

            'Backup completed',

            'Database backup created successfully',

            'database'

        );

        $this->logActivity(

            'Backup created',

            'database'

        );

        return back()->with(
            'success',
            'Backup created successfully'
        );
    }


    private function folderSize($path)
    {
        if (!File::exists($path)) {
            return 0;
        }

        $size = 0;

        foreach (File::allFiles($path) as $file) {
            $size += $file->getSize();
        }

        return round(
            $size / 1048576,
            2
        );
    }

    public function restoreBackup($file)
    {
        $backup = storage_path(
            'app/private/' . $file
        );

        if (
            !File::exists($backup)
        ) {
            return back()->with(
                'error',
                'Backup file not found'
            );
        }

        $command = sprintf(
            'mysql -u%s -p%s %s < "%s"',
            env('DB_USERNAME'),
            env('DB_PASSWORD'),
            env('DB_DATABASE'),
            $backup
        );

        exec($command);

        $this->createNotification(

            'Backup restored',

            'Database backup restored successfully',

            'database'

        );

        $this->logActivity(

            'Backup restored',

            'database'

        );

        return back()->with(
            'success',
            'Backup restored successfully'
        );
    }


    public function downloadBackup()
    {
        $backupPath = storage_path(
            'app/private'
        );

        if (!File::exists($backupPath)) {

            return back()->with(
                'error',
                'Backup folder not found'
            );
        }

        $files = File::allFiles(
            $backupPath
        );

        if (count($files) === 0) {

            return back()->with(
                'error',
                'No backup found'
            );
        }

        $latest = collect($files)
            ->sortByDesc(
                fn($file) => $file->getMTime()
            )
            ->first();

        return response()->download(
            $latest->getRealPath(),
            $latest->getFilename(),
            [
                'Content-Type' => 'application/zip'
            ]
        );
    }




    public function deleteNotification(
        Notification $notification
    ) {
        if (
            $notification->user_id
            != Auth::id()
        ) {
            abort(403);
        }

        $notification->delete();

        return back();
    }
}
