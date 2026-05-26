<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials =
            Testimonial::with(
                'user',
                'product'
            )

            ->when(

                $request->search,

                function ($query)
                use ($request) {

                    $query->whereHas(

                        'user',

                        function ($q)
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
}
