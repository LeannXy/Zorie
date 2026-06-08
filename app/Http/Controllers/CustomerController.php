<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use App\Models\Testimonial;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers =
            CustomerAccount::withCount(
                'orders'
            )

            ->latest()

            ->paginate(10);

        return view(

            'pages.customers',
            compact(
                'customers'
            )
        );
    }
    public function updateStatus(
        Request $request,
        CustomerAccount $customer
    ) {
        $customer->update([

            'status' =>
            $request->status

        ]);

        return back()
            ->with(

                'success',

                'Customer status updated'

            );
    }
    public function updateProfile(
        Request $request,
        CustomerAccount $customer
    ) {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email',

            'profile_photo' =>
            'nullable|image|mimes:jpg,png,jpeg|max:2048'

        ]);


        if ($request->hasFile(
            'profile_photo'
        )) {

            $image =

                $request
                ->file(
                    'profile_photo'
                )

                ->store(
                    'profiles',
                    'public'
                );

            $customer->update([

                'profile_photo' =>
                $image

            ]);
        }


        $customer->update([

            'name' =>
            $request->name,

            'email' =>
            $request->email

        ]);


        return back()

            ->with(

                'success',

                'Profile updated'

            );
    }

    public function export()
    {
        $fileName = 'customers-report.csv';

        $headers = [

            'Content-Type' => 'text/csv',

            'Content-Disposition' =>

            "attachment; filename=$fileName"

        ];

        $callback = function () {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv(

                $file,

                [
                    'ID',
                    'Name',
                    'Email',
                    'Phone',
                    'Status'

                ]

            );

            $customers =

                CustomerAccount::all();

            foreach (

                $customers as $customer

            ) {

                fputcsv(

                    $file,

                    [
                        $customer->id,

                        $customer->name,

                        $customer->email,

                        $customer->phone,

                        $customer->status

                    ]

                );
            }

            fclose($file);
        };

        return response()
            ->stream(
                $callback,
                200,
                $headers
            );
    }

    public function destroy(
        CustomerAccount $customer
    ) {
        $customer->delete();

        return back()->with(
            'success',
            'Customer deleted successfully'
        );
    }

    public function profile()
    { 
        $customerId = session('customer_id');
        $customer = CustomerAccount::find($customerId);
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }
        
        return view('pages.home.account.profile', compact('customer'));
    }

    public function orders(Request $request)
    { 
        $customer = CustomerAccount::find(session('customer_id'));
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $status = $request->query('status', 'all');

        $query = $customer->orders()->with(['items.product.images', 'items.testimonial']);

        if ($status !== 'all') {
            $statusMap = [
                'unpaid'  => ['Pending'],
                'process' => ['Paid', 'Processing'],
                'shipped' => ['Shipped'],
                'done'    => ['Completed']
            ];

            if (isset($statusMap[$status])) {
                $query->whereIn('status', $statusMap[$status]);
            }
        }

        $orders = $query->latest()->get();
        
        return view('pages.home.account.orders', compact('customer', 'orders'));
    }

    public function showOrder(Order $order)
    {
        $customer = CustomerAccount::find(session('customer_id'));
        
        if (!$customer) {
            return redirect()->route('customer.login');
        }

        // Pastikan order yang dibuka memang milik customer tersebut
        if ($order->customer_id !== $customer->id) {
            abort(403, 'Akses ditolak.');
        }

        $order->load(['items.product.images', 'items.testimonial']);
        
        return view('pages.home.account.order-detail', compact('customer', 'order'));
    }

    public function wishlist()
    { 
        $customer = CustomerAccount::find(session('customer_id'));

        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $wishlistItems = Wishlist::with('product.images')
            ->where('customer_id', $customer->id)
            ->get()
            ->map(fn($item) => $item->product)
            ->filter();
        
        return view('pages.home.account.wishlist', compact('customer', 'wishlistItems'));
    }

    public function reviews()
    { 
        $customerId = session('customer_id');
        $customer = CustomerAccount::find($customerId);

        if (!$customer) {
            return redirect()->route('customer.login');
        }

        $itemsToReview = collect();
        $completedOrders = $customer->orders()->where('status', 'Completed')->with(['items.product.images', 'items.testimonial'])->get();
        foreach($completedOrders as $order) {
            foreach($order->items as $item) {
                if (!$item->testimonial) {
                    $itemsToReview->push($item);
                }
            }
        }

        $myReviews = Testimonial::where('customer_id', $customer->id)
            ->with('product.images')
            ->latest()
            ->get();
        
        return view('pages.home.account.reviews', compact('customer', 'itemsToReview', 'myReviews'));
    }

  public function security()
    { 
        $customer = CustomerAccount::find(session('customer_id'));

        if (!$customer) {
            return redirect()->route('customer.login');
        }
        
        return view('pages.home.account.security', compact('customer'));
    }
 
}
