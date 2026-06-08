<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Address;
use Illuminate\Support\Str;
use App\Models\CustomerAccount;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cities = [];
        $shippingCost = 0;
        $defaultAddress = Address::where(
            'customer_id',
            session('customer_id')
        )
            ->where(
                'is_default',
                1
            )
            ->first();

        $cities = [
            [
                'city_id' => 'jepara',
                'city_name' => 'Jepara'
            ],
            [
                'city_id' => 'kudus',
                'city_name' => 'Kudus'
            ],
            [
                'city_id' => 'semarang',
                'city_name' => 'Semarang'
            ]
        ];

        if (session()->has('buy_now')) {
            $buyNow = session('buy_now');

            $product = Product::with([
                'images',
                'categories'
            ])->findOrFail(
                $buyNow['product_id']
            );

            $cartItems = collect([
                (object)[
                    'product' => $product,
                    'qty' => $buyNow['qty'],
                    'size' => $buyNow['size']
                ]
            ]);

            $total =
                $product->price
                * $buyNow['qty'];

            $totalWeight =
                ($product->weight ?? 1000)
                * $buyNow['qty'];

            return view(
                'pages.home.checkout',
                compact(
                    'cartItems',
                    'total',
                    'cities',
                    'shippingCost',
                    'totalWeight',
                    'defaultAddress'
                )
            );
        }

        // Jika ada item yang dipilih dari keranjang, simpan ke session
        if ($request->has('selected_items')) {
            session(['checkout_items' => $request->selected_items]);
        }

        $cartQuery = Cart::with([
            'product.images',
            'product.categories'
        ])
            ->where('customer_id', session('customer_id'));

        // Filter hanya item yang dipilih jika ada di session
        if (session()->has('checkout_items')) {
            $cartQuery->whereIn('id', session('checkout_items'));
        }

        $cartItems = $cartQuery->get();

        $total = $cartItems->sum(function ($item) {

            return
                $item->product->price
                * $item->qty;
        });

        $totalWeight = $cartItems->sum(function ($item) {

            return ($item->product->weight ?? 1000)
                * $item->qty;
        });


        return view(
            'pages.home.checkout',
            compact(
                'cartItems',
                'total',
                'cities',
                'shippingCost',
                'totalWeight',
                'defaultAddress'
            )
        );
    }

    public function success(Order $order)
    {
        $customer = CustomerAccount::find(session('customer_id'));
        if (!$customer || $order->customer_id != $customer->id) {
            return redirect()->route('home');
        }

        $order->load(['items.product.images', 'customer', 'items.testimonial']);

        return view('pages.home.order-success', compact('order', 'customer'));
    }

    public function downloadInvoice(Order $order)
    {
        $customer = CustomerAccount::find(session('customer_id'));
        if (!$customer || $order->customer_id != $customer->id) {
            abort(403);
        }

        $order->load(['items.product', 'customer']);

        // Memastikan menggunakan class Pdf dari library yang diinstal
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.home.invoice-pdf', compact('order', 'customer'));

        return $pdf->download('Invoice-' . $order->order_number . '.pdf');
    }

    public function process(Request $request)
    {
        $request->validate([

            'payment' => 'required',
            'shipping_cost' => 'required|numeric'

        ]);

        $customerId = session('customer_id');
        $items = collect();

        // Perbaikan: Ambil data dari Session jika Buy Now, atau dari Cart jika normal
        if (session()->has('buy_now')) {
            $buyNow = session('buy_now');
            $product = Product::findOrFail($buyNow['product_id']);

            $items->push((object)[
                'product_id' => $product->id,
                'product'    => $product,
                'qty'        => $buyNow['qty'],
                'size'       => $buyNow['size'],
                'price'      => $product->price
            ]);
        } else {
            $cartItemsQuery = Cart::with('product')
                ->where('customer_id', $customerId);

            // Hanya ambil item yang sebelumnya dipilih di halaman checkout/cart
            if (session()->has('checkout_items')) {
                $cartItemsQuery->whereIn('id', session('checkout_items'));
            }

            $cartItems = $cartItemsQuery->get();

            foreach ($cartItems as $cart) {
                $items->push((object)[
                    'product_id' => $cart->product_id,
                    'product'    => $cart->product,
                    'qty'        => $cart->qty,
                    'size'       => $cart->size,
                    'price'      => $cart->product->price
                ]);
            }
        }

        if ($items->isEmpty()) {
            return back()->with('error', 'Keranjang atau pesanan kosong.');
        }

        // Hitung total dari koleksi items yang sudah disatukan
        $total = $items->sum(function ($item) {
            return $item->price * $item->qty;
        });

        $defaultAddress = Address::where(
            'customer_id',
            session('customer_id')
        )
            ->where(
                'is_default',
                1
            )
            ->first();

        if (!$defaultAddress) {

            return back()->with(
                'error',
                'Silakan tambahkan alamat utama terlebih dahulu'
            );
        }
        $shippingCost = $request->shipping_cost;
        foreach ($items as $item) {

            if ($item->product->stock < $item->qty) {

                return back()->with(
                    'error',
                    'Stok produk ' .
                        $item->product->name .
                        ' tidak mencukupi'
                );
            }

            $size = $item->product->sizes()
                ->where('size', $item->size)
                ->first();

            if (!$size || $size->stock < $item->qty) {

                return back()->with(
                    'error',
                    'Stok ukuran ' .
                        $item->size .
                        ' untuk produk ' .
                        $item->product->name .
                        ' tidak mencukupi'
                );
            }
        }
        $order = Order::create([

            'order_number' =>
            'ZR-' . now()->format('YmdHis'),

            'customer_id' =>
            session('customer_id'),

            'address' =>
            $defaultAddress->address,

            'city' =>
            $defaultAddress->city,

            'postal_code' =>
            $defaultAddress->postal_code,

            'shipping_cost' =>
            $shippingCost,

            'total' =>
            $total + $shippingCost,

            'payment_method' =>
            $request->payment,

            'status' =>
            'Pending',

            'size'   => $request->size

        ]);

        foreach ($items as $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->qty,
                'price' => $item->price,
                'size' => $item->size,
            ]);

            // Product::where(
            //     'id',
            //     $item->product_id
            // )->decrement(
            //     'stock',
            //     $item->qty
            // );
        }
        // $product = Product::find($item->product_id);

        // $size = $product->sizes()
        //     ->where('size', $item->size)
        //     ->first();

        // if ($size) {
        //     $size->decrement('stock', $item->qty);
        // }
        // Hapus keranjang atau sesi buy_now
        if (session()->has('buy_now')) {
            session()->forget('buy_now');
            session()->forget('checkout_items');
        } else {
            // Hapus hanya item yang di-checkout dari keranjang
            $cartDeleteQuery = Cart::where('customer_id', session('customer_id'));
            if (session()->has('checkout_items')) {
                $cartDeleteQuery->whereIn('id', session('checkout_items'));
            }
            $cartDeleteQuery->delete();

            session()->forget('checkout_items');
        }

        // Jika COD, langsung ke halaman sukses
        if ($request->payment === 'COD') {

    $order->load('items');

    foreach ($order->items as $item) {

                $product = Product::find($item->product_id);

                if (!$product) {
                    continue;
                }

                // Kurangi stok produk
                if ($product->stock >= $item->quantity) {

                    $product->decrement(
                        'stock',
                        $item->quantity
                    );
                }

                // Kurangi stok ukuran
                $size = $product->sizes()
                    ->where('size', $item->size)
                    ->first();

                if (
                    $size &&
                    $size->stock >= $item->quantity
                ) {

                    $size->decrement(
                        'stock',
                        $item->quantity
                    );
                }
            }

            $order->update([
                'status' => 'Completed'
            ]);

            return redirect()->route(
                'checkout.success',
                $order->id
            );
        }

        // Integrasi Midtrans untuk pembayaran digital
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $customer = CustomerAccount::find(session('customer_id'));

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int)$order->total,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
        ];

        // Memetakan pilihan user ke metode pembayaran spesifik di Midtrans
        $paymentMapping = [
            'QRIS'             => ['qris', 'gopay', 'shopeepay'],
            'BCA Transfer'     => ['bca_va'],
            'Mandiri Transfer' => ['echannel', 'mandiri_va'],
            'BNI/BRI Transfer' => ['bni_va', 'bri_va'],
            'Retail Outlet'    => ['indomaret', 'alfamart'],
        ];

        if (isset($paymentMapping[$request->payment])) {
            $params['enabled_payments'] = $paymentMapping[$request->payment];
        }

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('pages.home.payment', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');

        $hashed = hash(
            "sha512",
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($hashed != $request->signature_key) {
            return response()->json([
                'status' => 'invalid_signature'
            ], 403);
        }

        if (!in_array(
            $request->transaction_status,
            ['capture', 'settlement']
        )) {
            return response()->json([
                'status' => 'ignored'
            ]);
        }

        $order = Order::with([
            'items',
            'items.product'
        ])
            ->where(
                'order_number',
                $request->order_id
            )
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'order_not_found'
            ], 404);
        }

        // Cegah stok berkurang 2x
        if ($order->status === 'Paid') {
            return response()->json([
                'status' => 'already_paid'
            ]);
        }

        $order->update([
            'status' => 'Paid'
        ]);

        foreach ($order->items as $item) {

            $product = Product::find(
                $item->product_id
            );

            if (!$product) {
                continue;
            }

            // Kurangi stok produk
            if ($product->stock >= $item->quantity) {

                $product->decrement(
                    'stock',
                    $item->quantity
                );
            }

            // Kurangi stok ukuran
            $size = $product->sizes()
                ->where(
                    'size',
                    $item->size
                )
                ->first();

            if (
                $size &&
                $size->stock >= $item->quantity
            ) {

                $size->decrement(
                    'stock',
                    $item->quantity
                );
            }
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function buyNow(Request $request)
    {
        $request->validate([

            'product_id' => 'required',

            'size' => 'required',

            'qty' => 'required'

        ]);

        session([
            'buy_now' => [

                'product_id' => $request->product_id,

                'size' => $request->size,

                'qty' => $request->qty

            ]

        ]);

        return redirect()->route(
            'checkout'
        );
    }

    public function getCities(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get(
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination',
            [
                'search' => $request->search,
            ]
        );

        return response()->json(
            $response->json()
        );
    }


    public function checkOngkir(Request $request)
    {
        try {

            $weight = $request->input('weight', 1000);

            $defaultAddress = Address::where(
                'customer_id',
                session('customer_id')
            )
                ->where('is_default', 1)
                ->first();

            if (!$defaultAddress) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat utama tidak ditemukan'
                ], 404);
            }

            $response = Http::withHeaders([
                'key' => env('RAJAONGKIR_API_KEY')
            ])
                ->asForm()
                ->post(
                    'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
                    [
                        'origin' => env('RAJAONGKIR_ORIGIN_ID'),
                        'destination' => $defaultAddress->rajaongkir_city_id,
                        'weight' => $weight,
                        'courier' => 'jne'
                    ]
                );

            return response()->json(
                $response->json()
            );
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
