<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu untuk melihat wishlist.');
        }

        // Ambil data wishlist dari database beserta relasi gambarnya
        $wishlists = Wishlist::with(['product.images'])
            ->where('customer_id', $customerId)
            ->get();

        // Ambil koleksi produk dari relasi wishlist
        $wishlistItems = $wishlists->map(fn($item) => $item->product)->filter();

        return view('pages.home.wishlist', [
            'wishlistItems' => $wishlistItems
        ]);
    }

    public function add(Product $product)
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        // Simpan ke database jika belum ada (menghindari duplikasi)
        Wishlist::firstOrCreate([
            'customer_id' => $customerId,
            'product_id' => $product->id
        ]);

        $wishlistCount = Wishlist::where('customer_id', $customerId)->count();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke wishlist',
            'wishlistCount' => $wishlistCount
        ]);
    }

    public function remove($productId)
    {
        $customerId = session('customer_id');
        if (!$customerId) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        // Hapus dari database
        Wishlist::where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->delete();

        $wishlistCount = Wishlist::where('customer_id', $customerId)->count();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari wishlist',
            'wishlistCount' => $wishlistCount
        ]);
    }

    public function count()
    {
        $customerId = session('customer_id');
        $count = $customerId ? Wishlist::where('customer_id', $customerId)->count() : 0;

        return response()->json([
            'count' => $count
        ]);
    }

    public function clear()
    {
        $customerId = session('customer_id');
        if ($customerId) {
            Wishlist::where('customer_id', $customerId)->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Wishlist berhasil dikosongkan',
            'wishlistCount' => 0
        ]);
    }
}