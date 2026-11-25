<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories =
            Category::with([
                'banners',
                'products' => fn ($query) => $query->limit(4),
                'products.images',
                'products.categories'
            ])
            ->where(
                'featured',
                true
            )
            ->where(
                'status',
                true
            )
            ->get();

        return view(
            'pages.home.index',
            compact(
                'featuredCategories'
            )
        );
    }
}
