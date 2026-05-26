<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [

        'store_name',
        'store_email',
        'store_phone',
        'currency',
        'timezone',
        'maintenance_mode',
        'auto_backup',

        'low_stock_notification',
        'backup_notification',
        'email_notification',

        'new_order_notification',
        'order_status_notification',
        'payment_notification',

        'compact_sidebar',
        'fixed_header',
        'show_animations',
        'show_statistics',
        'show_product_chart',

    ];
}
