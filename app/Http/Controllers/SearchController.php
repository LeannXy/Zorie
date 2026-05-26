<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\CustomerAccount;

class SearchController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $results = [];


    foreach(
        Product::where(
            'name',
            'like',
            "%{$search}%"
        )->take(5)->get()
        as $item
    ){

        $results[] = [

            'title'=>$item->name,

            'type'=>'Product',

            'icon'=>'package',

            'url'=>route(
                'products'
            )

        ];
    }


    foreach(
        CustomerAccount::where(
            'name',
            'like',
            "%{$search}%"
        )->take(5)->get()
        as $item
    ){

        $results[]=[

            'title'=>$item->name,

            'type'=>'Customer',

            'icon'=>'user',

            'url'=>route(
                'customers'
            )

        ];
    }


    foreach(
        Order::where(
            'order_number',
            'like',
            "%{$search}%"
        )->take(5)->get()
        as $item
    ){

        $results[]=[

            'title'=>$item->order_number,

            'type'=>'Order',

            'icon'=>'shopping-cart',

            'url'=>route(
                'orders.show',
                $item->id
            )

        ];
    }

    return response()->json(
        $results
    );
}
}
