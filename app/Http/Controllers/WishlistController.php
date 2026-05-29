<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $wishlistItems = [];

        foreach ($wishlist as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $wishlistItems[] = $product;
            }
        }

        return view('pages.wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }

    public function add(Product $product)
    {
        $wishlist = session()->get('wishlist', []);

        if (!in_array($product->id, $wishlist)) {
            $wishlist[] = $product->id;
            session()->put('wishlist', $wishlist);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlistCount' => count($wishlist)
        ]);
    }

    public function remove($productId)
    {
        $wishlist = session()->get('wishlist', []);
        $wishlist = array_filter($wishlist, fn($id) => $id != $productId);
        session()->put('wishlist', array_values($wishlist));

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlistCount' => count($wishlist)
        ]);
    }

    public function count()
    {
        $wishlist = session()->get('wishlist', []);

        return response()->json([
            'count' => count($wishlist)
        ]);
    }

    public function clear()
    {
        session()->forget('wishlist');

        return response()->json([
            'success' => true,
            'message' => 'Wishlist cleared',
            'wishlistCount' => 0
        ]);
    }
}
