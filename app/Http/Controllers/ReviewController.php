<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5',
        ]);

        $orderItem = OrderItem::with('order')->findOrFail($request->order_item_id);
        $customerId = session('customer_id');

        // Pastikan order milik customer tersebut dan statusnya sudah 'Completed'
        if ($orderItem->order->customer_id != $customerId || $orderItem->order->status !== 'Completed') {
            return back()->with('error', 'Anda hanya dapat mengulas produk dari pesanan yang telah selesai.');
        }

        // Simpan ulasan ke database
        Testimonial::create([
            'customer_id' => $customerId,
            'product_id' => $orderItem->product_id,
            'order_id' => $orderItem->order_id,
            'order_item_id' => $orderItem->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda telah berhasil disimpan.');
    }
}