<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(
        Request $request
    ) {

        $orders =
            Order::with(
                'customer',
                'items.product'
            )

            ->when(

                $request->search,

                function ($query)
                use ($request) {

                    $query

                        ->where(

                            'id',

                            $request->search

                        )

                        ->orWhere(

                            'order_number',

                            'like',

                            '%' . $request->search . '%'

                        )

                        ->orWhereHas(

                            'customer',

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



        $totalOrders =
            Order::count();

        $pendingOrders =
            Order::where(
                'status',
                'Pending'
            )->count();


        $completedOrders =
            Order::where(
                'status',
                'Completed'
            )->count();


        $totalRevenue =
            Order::where(
                'status',
                'Completed'
            )

            ->sum(
                'total'
            );



        return view(

            'pages.orders',

            compact(

                'orders',
                'totalOrders',
                'pendingOrders',
                'completedOrders',
                'totalRevenue'

            )

        );
    }

    public function updateStatus(
        Request $request,
        Order $order
    ) {

        $order->update([

            'status' =>
            $request->status

        ]);

        $this->createNotification(

            'Order Updated',

            'Order ' .
                $order->order_number .
                ' status changed to ' .
                $request->status,

            'shopping-cart'

        );

        $this->logActivity(

            'Updated order: ' .
                $order->order_number,

            'shopping-cart'

        );

        return back()
            ->with(

                'success',

                'Order updated successfully'

            );
    }

    public function bulkUpdate(
        Request $request
    ) {

        $request->validate([

            'ids' => 'required|array',

            'ids.*' => 'exists:orders,id',

            'status' => 'required'

        ]);

        Order::whereIn(

            'id',

            $request->ids

        )

            ->update([

                'status' =>
                $request->status

            ]);

        $this->createNotification(

            'Orders Updated',

            count($request->ids) .
                ' orders updated',

            'shopping-cart'

        );

        $this->logActivity(

            'Bulk updated orders',

            'shopping-cart'

        );

        return response()->json([

            'success' => true,

            'message' =>
            'Orders updated successfully'

        ]);
    }



    public function bulkDelete(
        Request $request
    ) {
        $request->validate([

            'ids' => 'required|array',

            'ids.*' => 'exists:orders,id'

        ]);

        $orders = Order::whereIn(
            'id',
            $request->ids
        )->get();

        $orderNumbers = $orders
            ->pluck(
                'order_number'
            )
            ->join(', ');

        Order::whereIn(
            'id',
            $request->ids
        )->delete();

        $this->createNotification(

            'Orders Deleted',

            'Deleted orders: ' .
                $orderNumbers,

            'trash'

        );

        $this->logActivity(

            'Bulk deleted orders',

            'trash'

        );

        return response()->json([

            'success' => true,

            'message' =>
            'Orders deleted successfully'

        ]);
    }

    public function show(
        Order $order
    ) {
        $order->load(

            'customer',
            'items.product'

        );

        return view(

            'pages.order-detail',

            compact(
                'order'
            )

        );
    }

    public function export()
    {
        return response()->stream(

            function () {

                $file = fopen(
                    'php://output',
                    'w'
                );

                fputcsv(

                    $file,

                    [

                        'ID',
                        'Order Number',
                        'Customer',
                        'Total',
                        'Status'

                    ]

                );

                $orders =
                    Order::with(
                        'customer'
                    )->get();

                foreach (

                    $orders as $order

                ) {

                    fputcsv(

                        $file,

                        [

                            $order->id,
                            $order->order_number,
                            $order->customer?->name,
                            $order->total,
                            $order->status

                        ]

                    );
                }

                fclose($file);
            },

            200,

            [

                'Content-Type' => 'text/csv',
                'Content-Disposition' =>
                'attachment; filename=orders-report.csv'

            ]

        );
    }

    public function destroy(
        Order $order
    ) {
        $orderNumber =
            $order->order_number;

        $order->delete();

        $this->createNotification(

            'Order Deleted',

            'Order ' .
                $orderNumber .
                ' was deleted',

            'trash'

        );

        $this->logActivity(

            'Deleted order: ' .
                $orderNumber,

            'trash'

        );

        return back()->with(

            'success',

            'Order deleted successfully'

        );
    }
}
