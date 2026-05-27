<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Illuminate\Http\Request;

abstract class Controller
{

    protected function createNotification(
        $title,
        $message,
        
        $icon = 'bell'
    ) {

        $settings =
            Setting::first();

        $titleLower =
            strtolower($title);


        // New order
        if (

            str_contains(
                $titleLower,
                'new order'
            )

            &&

            !$settings?->new_order_notification

        ) {

            return;
        }


        // Order status
        if (

            str_contains(
                $titleLower,
                'status'
            )

            &&

            !$settings?->order_status_notification

        ) {

            return;
        }


        // Payment
        if (

            str_contains(
                $titleLower,
                'payment'
            )

            &&

            !$settings?->payment_notification

        ) {

            return;
        }


        // Low stock
        if (

            str_contains(
                $titleLower,
                'stock'
            )

            &&

            !$settings?->low_stock_notification

        ) {

            return;
        }


        // Backup
        if (

            str_contains(
                $titleLower,
                'backup'
            )

            &&

            !$settings?->backup_notification

        ) {

            return;
        }


        // Email
        if (

            str_contains(
                $titleLower,
                'email'
            )

            &&

            !$settings?->email_notification

        ) {

            return;
        }


        $users =
            User::all();

        foreach (

            $users as $user

        ) {

            Notification::create([

                'user_id' =>
                $user->id,

                'title' =>
                $title,

                'message' =>
                $message,

                'icon' =>
                $icon

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
