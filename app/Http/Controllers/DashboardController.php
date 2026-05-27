<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\CustomerAccount;
use Illuminate\Support\Facades\DB;
use App\Models\Testimonial;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $revenue =
            Order::where(
                'status',
                'Completed'
            )
            ->sum('total');

        $recentOrders =
            Order::with(
                'customer',
                'items.product'
            )
            ->latest()
            ->take(5)
            ->get();


        $salesData =

            Order::where(
                'status',
                'Completed'
            )

            ->select(

                DB::raw(
                    'MONTH(created_at) as month'
                ),

                DB::raw(
                    'SUM(total) as total'
                )

            )

            ->groupBy(
                'month'
            )

            ->orderBy(
                'month'
            )

            ->get();


        $chartLabels = [];

        $chartValues = [];


        /* sesuaikan bulan*/
        $currentMonth =

            now()->month;

        $chartLabels = [];

        $chartValues = [];



        for (

            $i = 1;

            $i <= $currentMonth;

            $i++

        ) {

            $chartLabels[] =

                date(

                    'M',

                    mktime(
                        0,
                        0,
                        0,
                        $i,
                        1
                    )

                );


            $monthData =

                $salesData
                ->firstWhere(
                    'month',
                    $i
                );


            $chartValues[] =

                (int)(

                    $monthData?->total
                    ?? 0

                );
        }

        $activities =
            Order::with(
                'customer'
            )

            ->latest()

            ->take(5)

            ->get();


        // Average rating
        $averageRating =

            round(

                Testimonial::avg(
                    'rating'
                ),

                1

            );


        // Top product

        $topProduct =

            OrderItem::select(

                'product_id',

                DB::raw(
                    'SUM(quantity) as sold'
                )

            )

            ->with(
                'product'
            )

            ->groupBy(
                'product_id'
            )

            ->orderByDesc(
                'sold'
            )

            ->first();


        // Monthly growth

        $currentMonth =

            Order::whereMonth(

                'created_at',
                now()->month

            )

            ->count();


        $lastMonth =

            Order::whereMonth(

                'created_at',
                now()->subMonth()->month

            )

            ->count();


        $growth =

            $lastMonth > 0

            ?

            round(

                (($currentMonth - $lastMonth)

                    / $lastMonth) * 100,

                1

            )

            :

            100;

        return view(
            'pages.dashboard.dashboard',
            [
                'activities' => $activities,

                'revenue' => $revenue,

                'chartLabels' =>
                $chartLabels,

                'chartValues' =>
                $chartValues,

                'orders' =>
                Order::count(),

                'products' =>
                Product::count(),

                'customers' =>
                CustomerAccount::count(),

                'recentOrders' =>
                $recentOrders,

                'averageRating' =>
                $averageRating,

                'topProduct' =>
                $topProduct,

                'growth' =>
                $growth,

            ]
        );
    }

    public function export()
    {
        $fileName = 'dashboard-report.csv';

        $headers = [

            'Content-Type' => 'text/csv',

            'Content-Disposition' =>

            "attachment; filename=$fileName"

        ];


        $callback = function () {

            $file =

                fopen(
                    'php://output',
                    'w'
                );


            // Dashboard Summary

            fputcsv(

                $file,

                ['Dashboard Summary']

            );

            fputcsv(

                $file,

                [

                    'Revenue',

                    Order::where(
                        'status',
                        'Completed'
                    )->sum(
                        'total'
                    )

                ]

            );

            fputcsv(

                $file,

                [

                    'Orders',

                    Order::count()

                ]

            );

            fputcsv(

                $file,

                [

                    'Products',

                    Product::count()

                ]

            );

            fputcsv(

                $file,

                [

                    'Customers',

                    CustomerAccount::count()

                ]

            );

            fputcsv(

                $file,

                [

                    'Average Rating',

                    round(

                        Testimonial::avg(
                            'rating'
                        ),

                        1

                    )

                ]

            );


            // kosong

            fputcsv($file, []);


            // Order section

            fputcsv(

                $file,

                ['Order Details']

            );

            fputcsv(

                $file,

                [

                    'Order Number',
                    'Customer',
                    'Total',
                    'Payment',
                    'Status',
                    'Date'

                ]

            );


            $orders =

                Order::with(
                    'customer'
                )->get();


            foreach (

                $orders as $order

            ) {

                fputcsv(

                    $file,

                    [

                        $order->order_number,

                        $order->customer?->name,

                        $order->total,

                        $order->payment_method,

                        $order->status,

                        $order->created_at

                    ]

                );
            }

            fclose(
                $file
            );
        };


        return response()

            ->stream(

                $callback,

                200,

                $headers

            );
    }
}
