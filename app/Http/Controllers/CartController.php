<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');

        // Jika tidak login, tampilkan halaman keranjang kosong atau arahkan ke login
        if (!$customerId) {
            return view('pages.home.cart', [
                'cartItems' => collect(),
                'total' => 0,
                'cartCount' => 0
            ]);
        }

        $cartItems = Cart::with([
            'product.images',
            'product.categories'
        ])
            ->where(
                'customer_id',
                $customerId
            )
            ->get();

        $total = $cartItems->sum(function ($item) {

            return $item->product->price
                * $item->qty;
        });

        return view(
            'pages.home.cart',
            [

                'cartItems' => $cartItems,

                'total' => $total,

                'cartCount' => $cartItems->sum('qty')

            ]
        );
    }

    public function update(
        Request $request,
        Cart $cart
    ) {
        $customerId = session('customer_id');
        
        // Pastikan item keranjang milik customer yang sedang login
        if (!$customerId || $cart->customer_id != $customerId) {
            abort(403);
        }

        $request->validate([

            'qty' => 'required|integer|min:1'

        ]);

        $cart->update([

            'qty' => $request->qty

        ]);

        return back();
    }

    public function count()
    {
        $customerId = session('customer_id');
        
        if ($customerId) {
            $count = Cart::where('customer_id', $customerId)->sum('qty');
        } else {
            $count = collect(session()->get('cart', []))->sum();
        }

        return response()->json([
            'count' => (int)$count
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        
        $customerId = session('customer_id');
        
        // Hapus data keranjang di database untuk customer ini
        if ($customerId) {
            Cart::where('customer_id', $customerId)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'cartCount' => 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'product_id' => 'required',

            'size' => 'required',

            'qty' => 'required|integer|min:1'

        ]);

        $customerId = session('customer_id');

        // Proteksi: Customer harus login untuk menggunakan keranjang database
        if (!$customerId) {
            return redirect()->route('customer.login')
                ->with('error', 'Silakan login terlebih dahulu untuk menambahkan produk ke keranjang.');
        }

        $cart = Cart::where(
            'customer_id',
            $customerId
        )
            ->where(
                'product_id',
                $request->product_id
            )
            ->where(
                'size',
                $request->size
            )
            ->first();

        if ($cart) {

            $cart->increment(
                'qty',
                $request->qty
            );
        } else {

            Cart::create([

                'customer_id' =>
                $customerId,

                'product_id' =>
                $request->product_id,

                'size' =>
                $request->size,

                'qty' =>
                $request->qty,

            ]);
        }

        return back()->with(
            'success',
            $request->qty . ' produk berhasil ditambahkan ke keranjang'
        );
    }
    public function destroy(Cart $cart)
    {
        $customerId = session('customer_id');

        // Pastikan item keranjang milik customer yang sedang login
        if (!$customerId || $cart->customer_id != $customerId) {
            abort(403);
        }

        $cart->delete();

        return back()->with(
            'success',
            'Produk dihapus'
        );
    }
}
