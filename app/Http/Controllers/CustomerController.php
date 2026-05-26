<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
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
}
