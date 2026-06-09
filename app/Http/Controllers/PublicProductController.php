<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'images',
            'categories',
            'sizes'
        ]);

        if ($request->filled('category')) {

            $query->whereHas(
                'categories',
                fn($q) =>
                $q->where(
                    'slug',
                    $request->category
                )
            );
        }

        if ($request->filled('search')) {

            $query->where(
                'name',
                'like',
                '%' .
                    $request->search .
                    '%'
            );
        }
        switch ($request->sort) {

            case 'price_low':

                $query->orderBy(
                    'price'
                );

                break;

            case 'price_high':

                $query->orderByDesc(
                    'price'
                );

                break;

            default:

                $query->latest();

                break;
        }
        if ($request->filled('price')) {

            switch ($request->price) {

                case 'under_500k':

                    $query->where(
                        'price',
                        '<',
                        500000
                    );

                    break;

                case '500k_1m':

                    $query->whereBetween(
                        'price',
                        [
                            500000,
                            1000000
                        ]
                    );

                    break;

                case 'above_1m':

                    $query->where(
                        'price',
                        '>',
                        1000000
                    );

                    break;
            }
        }

        if ($request->filled('size')) {

            $query->whereHas(
                'sizes',
                function ($q) use ($request) {

                    $q->where(
                        'size',
                        $request->size
                    );
                }
            );
        }
        if ($request->filled('size')) {

            $query->whereHas(
                'sizes',
                fn($q) =>
                $q->where(
                    'size',
                    $request->size
                )
            );
        }

        $products = $query
            ->paginate(16);




        $categories = Category::where(
            'status',
            true
        )->get();
        $sizes = \App\Models\ProductSize::query()
            ->select('size')
            ->distinct()
            ->orderBy('size')
            ->pluck('size');

        return view(
            'pages.home.sections.all-products',
            compact(
                'products',
                'categories',
                'sizes'
            )

        );
    }
public function search(Request $request)
{
    $products = Product::with([
        'images',
        'categories'
    ]);

    if ($request->filled('q')) {

        $products->where(
            'name',
            'like',
            '%' . $request->q . '%'
        );

    }

    return view(
        'pages.home.search',
        [
            'products' => $products
                ->latest()
                ->paginate(12)
        ]
    );
}
  public function show(Product $product)
{
    $product->load([
        'images',
        'categories',
        'sizes',
        'reviews.customer'
    ]);

    $recommendations = Product::with([
        'images',
        'categories'
    ])
        ->where('id', '!=', $product->id)
        ->limit(4)
        ->get();

    $isWishlisted = false;

    if (session('customer_id')) {

        $isWishlisted = \App\Models\Wishlist::where(
            'customer_id',
            session('customer_id')
        )
        ->where(
            'product_id',
            $product->id
        )
        ->exists();
    }

    return view(
        'pages.home.sections.product-detail',
        compact(
            'product',
            'recommendations',
            'isWishlisted'
        )
    );
}
}
