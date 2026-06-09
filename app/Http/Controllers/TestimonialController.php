<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials =
           Testimonial::with('customer', 'product')

            ->when(

                $request->search,

                function ($query)
                use ($request) {

                    $query->whereHas('customer', function ($q)
                        use ($request) {

                            $q->where(
                                'name',
                                'like',
                                '%' . $request->search . '%'
                            );
                        }

                    )

                        ->orWhereHas(

                            'product',

                            function ($q)
                            use ($request) {

                                $q->where(
                                    'name',
                                    'like',
                                    '%' . $request->search . '%'
                                );
                            }

                        );
                }

            )

            ->when(

                $request->status,

                function ($query)
                use ($request) {

                    $query->where(
                        'status',
                        $request->status
                    );
                }

            )

            ->latest()

            ->paginate(10)

            ->withQueryString();

        return view(
            'pages.testimonials',
            compact(
                'testimonials'
            )
        );
    }

    public function status(
        Request $request,
        Testimonial $testimonial
    ) {

        $testimonial->update([

            'status' =>
            $request->status

        ]);

        return back();
    }


    public function updateStatus(
        Testimonial $testimonial
    ) {
        $testimonial->update([

            'status' =>

            $testimonial->status
                === 'Approved'

                ? 'Hidden'

                : 'Approved'

        ]);

        return back()

            ->with(

                'success',

                'Status updated'

            );
    }


    public function destroy(
        Testimonial $testimonial
    ) {
        $testimonial->delete();

        return back()
            ->with(

                'success',

                'Testimonial deleted'

            );
    }

    public function storeFromCustomer(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        $customer_id = session('customer_id');

        if (!$customer_id) {
            return back()->with('error', 'Anda harus login terlebih dahulu untuk menulis ulasan');
        }

        // Check if customer already reviewed this product
        $existingReview = Testimonial::where('customer_id', $customer_id)
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah menulis ulasan untuk produk ini');
        }

        Testimonial::create([
            'customer_id' => $customer_id,
            'product_id' => $validated['product_id'],
            'order_id' => $validated['order_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Ulasan Anda telah dikirim dan sedang menunggu persetujuan admin');
    }

    public function updateFromCustomer(Request $request, Testimonial $testimonial)
    {
        $customer_id = session('customer_id');

        if ($testimonial->customer_id != $customer_id) {
            return back()->with('error', 'Anda tidak berhak mengubah ulasan ini');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $testimonial->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Ulasan Anda telah diperbarui dan sedang menunggu persetujuan admin');
    }

    public function destroyFromCustomer(Testimonial $testimonial)
    {
        $customer_id = session('customer_id');

        if ($testimonial->customer_id != $customer_id) {
            return back()->with('error', 'Anda tidak berhak menghapus ulasan ini');
        }

        $testimonial->delete();

        return back()->with('success', 'Ulasan Anda telah dihapus');
    }
}
