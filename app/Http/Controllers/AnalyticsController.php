<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CustomerAccount;
use App\Models\Testimonial;
use Illuminate\Support\Facades\DB;


class AnalyticsController extends Controller
{
    public function index()
    {

        $revenue =
            Order::where(
                'status',
                'Completed'
            )
            ->sum(
                'total'
            );

        $orders =
            Order::count();

        $customers =
            CustomerAccount::count();

        $products =
            Product::count();

        $averageRating =
            round(
                Testimonial::avg(
                    'rating'
                ),
                1
            );

        $topProducts =

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

            ->take(5)

            ->get();

        $statusStats =

            Order::select(

                'status',

                DB::raw(
                    'COUNT(*) as total'
                )

            )

            ->groupBy(
                'status'
            )

            ->get();

        // Conversion Rate

        $totalVisitors = 1000;

        $conversionRate =

            $orders > 0

            ?

            round(

                ($orders / $totalVisitors) * 100,

                1

            )

            : 0;


        // Top customers

        $topCustomers =

            CustomerAccount::withCount(

                'orders'

            )

            ->orderByDesc(

                'orders_count'

            )

            ->take(5)

            ->get();


        // New customers this month

        $newCustomers =

            CustomerAccount::whereMonth(

                'created_at',

                now()->month

            )

            ->count();


        // Active customers

        $activeCustomers =

            CustomerAccount::has(

                'orders'

            )

            ->count();


        // Monthly revenue chart

        $monthlyRevenue =

            Order::select(

                DB::raw(
                    'MONTH(created_at) as month'
                ),

                DB::raw(
                    'SUM(total) as total'
                )

            )

            ->where(

                'status',

                'Completed'

            )

            ->groupBy(

                'month'

            )

            ->orderBy(

                'month'

            )

            ->get();

       $currentMonth=

now()->month;

$chartLabels=[];

$chartValues=[];


for(

$i=1;

$i<=$currentMonth;

$i++

){

    $chartLabels[]=

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


    $monthData=

    $monthlyRevenue
    ->firstWhere(
        'month',
        $i
    );


    $chartValues[]=

    $monthData
    ? $monthData->total
    : 0;

}

        return view(
            'pages.analytics',

            compact(

                'revenue',
                'orders',
                'customers',
                'products',
                'averageRating',
                'topProducts',
                'statusStats',
                'conversionRate',
                'topCustomers',
                'newCustomers',
                'activeCustomers',
                'monthlyRevenue',

                'chartLabels',
                'chartValues'

            )
        );
    }
}
