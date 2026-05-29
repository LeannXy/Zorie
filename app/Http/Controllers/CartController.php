<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('pages.cart', [
            'cartItems' => $cartItems,
            'total' => $total,
            'cartCount' => count($cart)
        ]);
    }

    public function add(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] += $quantity;
        } else {
            $cart[$product->id] = $quantity;
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cartCount' => count($cart)
        ]);
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cartCount' => count($cart)
        ]);
    }

    public function update($productId, Request $request)
    {
        $quantity = $request->input('quantity', 1);
        $cart = session()->get('cart', []);

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'cartCount' => count($cart)
        ]);
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        foreach ($cart as $quantity) {
            $count += $quantity;
        }

        return response()->json([
            'count' => $count
        ]);
    }

    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'cartCount' => 0
        ]);
    }
}
