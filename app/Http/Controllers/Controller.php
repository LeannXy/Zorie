<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function createNotification(
        $title,
        $message,
        $icon = 'bell'
    ) {

        $admins = User::all();

        foreach (
            $admins as $admin
        ) {

            Notification::create([

                'user_id' => $admin->id,

                'title' => $title,

                'message' => $message,

                'icon' => $icon

            ]);
        }
    }


    protected function logActivity(
        $action,
        $icon = 'activity'
    ) {

        ActivityLog::create([

            'user_id' => Auth::id(),

            'action' => $action,

            'icon' => $icon

        ]);
    }
}
