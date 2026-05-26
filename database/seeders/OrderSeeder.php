<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\CustomerAccount;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {

            $customer =
                CustomerAccount::inRandomOrder()
                ->first();

            $product =
                Product::inRandomOrder()
                ->first();

            if (!$customer || !$product) {
                return;
            }

            $quantity =
                rand(1, 3);


            $order = Order::create([

                'order_number' =>
                'ORD-100' . $i,

                'customer_id' =>
                $customer->id,

                'total' =>
                $product->price * $quantity,

                'payment_method' =>
                'Bank Transfer',

                'status' =>
                collect([

                    'Completed',
                    'Completed',
                    'Pending',
                    'Processing'

                ])->random(),

                'created_at' =>
                Carbon::now()->subMonths(
                    rand(0, 5)
                ),

                'updated_at' =>
                now()

            ]);


            OrderItem::create([

                'order_id' =>
                $order->id,

                'product_id' =>
                $product->id,

                'quantity' =>
                $quantity,

                'price' =>
                $product->price

            ]);
        }
    }
}
